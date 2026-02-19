import {KeepsakePdf} from "./lib/keepsake-pdf.ts";

window.keepsakePdfJs = new KeepsakePdf({
    scaleCoefficient: 2.25,
    anchorPoint: "__keepsake__pdf__viewer__"
});
