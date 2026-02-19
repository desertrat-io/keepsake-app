import {PDFDocumentProxy, PDFPageProxy} from "pdfjs-dist";

export interface IKeepsakePdf {
    render(pageNum: number, docUrl: string): void,

    getPage(pageNum: number): Promise<PDFPageProxy>,

    getDoc(docUrl: string): Promise<PDFDocumentProxy>

}

export interface KeepsakePdfConfig {
    anchorPoint: string | "__keepsake__pdf__viewer__",
    scaleCoefficient: number | 1.0
}
