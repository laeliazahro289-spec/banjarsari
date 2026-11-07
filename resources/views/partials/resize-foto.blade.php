<script>
(function () {
    // Foto dari HP biasanya >2 MB. Skrip ini memperkecilnya otomatis sebelum dikirim.
    document.querySelectorAll('input[type=file][data-resize]').forEach(function (inp) {
        inp.addEventListener('change', function () {
            var f = inp.files && inp.files[0];
            if (!f || !f.type || f.type.indexOf('image/') !== 0) return;
            var max = parseInt(inp.getAttribute('data-resize'), 10) || 900;
            var url = URL.createObjectURL(f), img = new Image();
            img.onload = function () {
                var k = Math.min(1, max / Math.max(img.width, img.height)), c = document.createElement('canvas');
                c.width = Math.round(img.width * k); c.height = Math.round(img.height * k);
                c.getContext('2d').drawImage(img, 0, 0, c.width, c.height);
                c.toBlob(function (b) {
                    URL.revokeObjectURL(url);
                    if (!b || typeof DataTransfer === 'undefined') return;
                    var nf = new File([b], (f.name.replace(/\.[^.]+$/, '') || 'foto') + '.jpg', { type: 'image/jpeg' });
                    var dt = new DataTransfer(); dt.items.add(nf); inp.files = dt.files;
                }, 'image/jpeg', 0.85);
            };
            img.onerror = function () { URL.revokeObjectURL(url); };
            img.src = url;
        });
    });
})();
</script>
