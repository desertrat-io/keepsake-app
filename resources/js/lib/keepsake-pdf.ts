import {getDocument, GlobalWorkerOptions, PageViewport, PDFDocumentProxy, PDFPageProxy} from "pdfjs-dist";
// @ts-ignore this is valid but typescript doesn't like it
import workerSrc from "pdfjs-dist/build/pdf.worker.min.mjs?url";
import {IKeepsakePdf, KeepsakePdfConfig} from "./keepsake-pdf.interface";


export class KeepsakePdf implements IKeepsakePdf {

    private readonly anchorPoint: string;
    private readonly workerSrc: string;
    private doc: PDFDocumentProxy | null = null;
    private docUrl: string | null = null;
    private docPromise: Promise<PDFDocumentProxy> | null = null;
    private page: PDFPageProxy | null = null;
    private scaleCoefficient: number;
    private viewport: PageViewport | null = null;
    private outputScale: number;

    constructor({anchorPoint, scaleCoefficient}: KeepsakePdfConfig) {
        if (workerSrc !== null) {
            GlobalWorkerOptions.workerSrc = workerSrc;
        }
        this.anchorPoint = anchorPoint;
        this.workerSrc = workerSrc;
        this.scaleCoefficient = scaleCoefficient;
        this.outputScale = window.devicePixelRatio || 1;
    }

    async getPage(pageNum: number): Promise<PDFPageProxy> {

        if (this.doc === null) {
            throw new Error("PDF document not initialized or invalid");
        }
        this.page?.cleanup(); // if we need to re-render the page
        this.page = await this.doc.getPage(pageNum);
        return this.page;
    }

    async getDoc(docUrl: string): Promise<PDFDocumentProxy> {
        if (this.doc) {
            return this.doc;
        }
        // for cases where render is called repeatedly before the promise resolves
        if (this.docPromise) {
            return this.docPromise;
        }

        this.docPromise = getDocument(docUrl).promise
            .then((doc) => {
                this.doc = doc;
                return doc;
            })
            .catch((err) => {
                this.docPromise = null;
                this.doc = null;
                throw err;
            });

        return this.docPromise;
    }

    get width(): number {
        if (this.viewport?.width !== undefined) {
            return Math.floor(this.viewport?.width * this.outputScale);
        }
        return 0;
    }

    get height(): number {
        if (this.viewport?.height !== undefined) {
            return Math.floor(this.viewport?.height * this.outputScale);
        }
        return 0;
    }

    get canvasWidth(): string {
        if (this.viewport?.width !== undefined) {
            return Math.floor(this.viewport?.width) + "px";
        }

        return "";
    }

    get canvasHeight(): string {
        if (this.viewport?.height !== undefined) {
            return Math.floor(this.viewport?.height) + "px";
        }

        return "";
    }

    get transform(): number[] | null {
        return this.outputScale !== 1 ? [this.outputScale, 0, 0, this.outputScale, 0, 0] : null;
    }

    get worker(): string {
        return this.workerSrc;
    }

    private async resolve(docUrl: string, pageNum: number): Promise<void> {
        const doc = await this.getDoc(docUrl);
        const page = await doc.getPage(pageNum);

        this.viewport = page.getViewport({scale: this.scaleCoefficient});

        const canvas = window.document.getElementById(this.anchorPoint);
        if (!(canvas instanceof HTMLCanvasElement)) {
            throw new Error(`Canvas element not found (or not a <canvas>) for id="${this.anchorPoint}".`);
        }

        const context = canvas.getContext("2d");
        if (!context) {
            throw new Error(`Could not get 2D context for canvas id="${this.anchorPoint}".`);
        }

        canvas.width = this.width;
        canvas.height = this.height;

        canvas.style.width = this.canvasWidth;

        canvas.style.height = this.canvasHeight;
        // condense the viewport and transform into finalized properties
        const viewport = this.viewport;
        const transform = this.transform ?? undefined;
        page.render({
            canvasContext: context,
            viewport,
            transform,
            canvas
        });
    }

    /**
     * The second parameter is optional. If provided the current document cache is destroyed
     * Also, this calls the internal async version to keep the front end api clean so the
     * client can remain minimal and not worry about managing promise state
     * @param pageNum
     * @param docUrl
     */
    render(pageNum: number, docUrl: string = ""): void {

        if (docUrl !== "" && docUrl !== this.docUrl && this.docUrl !== null) {
            this.doc?.destroy()
                .then(() => {
                    console.log("Document reset")
                    this.docUrl = docUrl;
                    this.doc = null;
                    this.docPromise = null;
                    this.page = null;
                    this.viewport = null;
                })
                // TODO: restructure, I don't like just calling resolve twice
                .then(() => {
                    this.resolve(docUrl, pageNum)
                        .catch((err) => {
                            console.error("[KeepsakePdf] render failed reset resolve:", err);
                        });
                })
                .catch(() => console.error("Problem destroying document"))
        } else {
            this.resolve(docUrl, pageNum)
                .catch((err) => {
                    console.error("[KeepsakePdf] render failed basic resolve:", err);
                });
        }
    }
}
