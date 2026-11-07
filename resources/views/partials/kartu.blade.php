@php
    $dataKartu = [
        'nama'    => $member->nama,
        'banom'   => $member->banom->nama,
        'lengkap' => $member->banom->tingkat ?? $member->banom->nama,
        'jabatan' => $member->jabatan,
        'alamat'  => $member->alamat ?: '-',
        'tahun'   => $member->tahun ?: date('Y'),
        'nia'     => $member->nia,
        'foto'    => $member->foto_url,
        'inisial' => strtoupper(mb_substr($member->nama, 0, 1)),
        'status'  => $member->status,
    ];
@endphp

<canvas id="cv" width="856" height="540"
    class="mx-auto rounded-2xl shadow-xl max-w-full"></canvas>

<script>
(function () {
    var M = @json($dataKartu);
    var cv = document.getElementById('cv');
    var x = cv.getContext('2d');

    var F = 'Arial, sans-serif';
    var S = 'Georgia, serif';

    function gambar(img) {

        // Background kartu
        var g = x.createLinearGradient(0, 0, 856, 540);
        g.addColorStop(0, '#16392c');
        g.addColorStop(.55, '#1f4d3b');
        g.addColorStop(1, '#4b8a70');

        x.fillStyle = g;
        x.fillRect(0, 0, 856, 540);

        // Hiasan background
        x.fillStyle = 'rgba(255,255,255,.08)';

        x.beginPath();
        x.arc(770, 100, 170, 0, 7);
        x.fill();

        x.beginPath();
        x.arc(70, 520, 150, 0, 7);
        x.fill();

        // Garis emas
        x.fillStyle = '#c9a24a';
        x.fillRect(0, 150, 856, 8);
        x.fillRect(0, 500, 856, 40);

        // Logo NU
        x.beginPath();
        x.arc(90, 78, 46, 0, 7);
        x.fill();

        x.fillStyle = '#16392c';
        x.font = 'bold 34px ' + S;
        x.textAlign = 'center';
        x.fillText('NU', 90, 90);

        // Judul kartu
        x.textAlign = 'left';
        x.fillStyle = '#fff';
        x.font = 'bold 30px ' + F;
        x.fillText('KARTU TANDA ANGGOTA', 160, 62);

        x.font = '22px ' + F;
        x.fillStyle = '#d9efe0';
        x.fillText(M.lengkap, 160, 98);

        // Foto anggota
        var px = 640;
        var py = 190;
        var pw = 170;
        var ph = 230;

        x.fillStyle = '#c9a24a';
        x.fillRect(px - 5, py - 5, pw + 10, ph + 10);

        if (img) {
            var r = Math.max(
                pw / img.width,
                ph / img.height
            );

            var w = img.width * r;
            var h = img.height * r;

            x.save();
            x.beginPath();
            x.rect(px, py, pw, ph);
            x.clip();

            x.drawImage(
                img,
                px + (pw - w) / 2,
                py + (ph - h) / 2,
                w,
                h
            );

            x.restore();

        } else {
            x.fillStyle = '#16392c';
            x.fillRect(px, py, pw, ph);

            x.fillStyle = '#c9a24a';
            x.font = 'bold 72px ' + S;
            x.textAlign = 'center';

            x.fillText(
                M.inisial,
                px + pw / 2,
                py + ph / 2 + 24
            );

            x.textAlign = 'left';
        }

        // Nama anggota
        x.fillStyle = '#fff';
        x.font = 'bold 40px ' + S;

        var nm = M.nama;

        while (
            x.measureText(nm).width > 560 &&
            nm.length > 3
        ) {
            nm = nm.slice(0, -1);
        }

        if (nm !== M.nama) {
            nm += '…';
        }

        x.fillText(nm, 50, 240);

        // Banom dan jabatan
        x.fillStyle = '#f0d27f';
        x.font = 'bold 26px ' + F;

        x.fillText(
            M.banom + ' — ' + M.jabatan,
            50,
            285
        );

        // Nomor anggota
        x.fillStyle = '#fff';
        x.font = '22px ' + F;

        x.fillText(
            'No. Anggota : ' + M.nia,
            50,
            350
        );

        // Alamat
        x.fillText(
            'Alamat/Ranting : ' + String(M.alamat).slice(0, 30),
            50,
            390
        );

        // Tahun bergabung
        x.fillText(
            'Bergabung : ' + M.tahun,
            50,
            430
        );

        // Footer kartu
        x.fillStyle = '#16392c';
        x.font = 'bold 18px ' + F;

        x.fillText(
            'Nahdlatul Ulama • Khidmah untuk Umat',
            50,
            527
        );
    }

    // Memuat foto
    if (M.foto) {
        var im = new Image();

        im.onload = function () {
            gambar(im);
        };

        im.onerror = function () {
            gambar(null);
        };

        im.src = M.foto;

    } else {
        gambar(null);
    }

    // Tombol download KTA
    var tombol = document.getElementById('unduh');

    if (tombol) {
        tombol.addEventListener('click', function () {

            cv.toBlob(function (b) {

                if (!b) return;

                var a = document.createElement('a');

                a.href = URL.createObjectURL(b);

                a.download = 'kartu-' +
                    M.nama.replace(/\s+/g, '-').toLowerCase() +
                    '.png';

                a.click();

                setTimeout(function () {
                    URL.revokeObjectURL(a.href);
                }, 1000);

            }, 'image/png');
        });
    }

})();
</script>