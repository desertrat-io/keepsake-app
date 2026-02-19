<div x-init="$wire.on('refresh-viewer-page', pageNum => {
console.log('Refreshing viewer page to', pageNum);
            draw(pageNum.pageNum);
        });">
    @vite(['resources/js/pdf.js'])
    <script defer>
        function draw(pageNum) {
            window.keepsakePdfJs.render(pageNum, "{{ Keepsake::getTemporarySignedUrl($documentPath) }}");
        }


        window.addEventListener('load', () => {
            draw(1);
        });

    </script>
</div>
