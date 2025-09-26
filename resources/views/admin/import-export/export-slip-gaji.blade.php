<div class="slip-container">
    <div class="header">
        Slip Gaji - {{ date('F Y') }}
    </div>

    <table class="table">
        <tr>
            <th>Nama Pegawai</th>
            <td>{{ $pegawai->nama_pegawai }}</td>
        </tr>
        <tr>
            <th>Jabatan</th>
            <td>{{ $pegawai->pegawai->jabatan->jabatan }}</td>
        </tr>
        <tr>
            <th>Bagian</th>
            <td>{{ $pegawai->pegawai->bagian->bagian }}</td>
        </tr>
    </table>

    <h5 class="mt-4">Rincian Gaji</h5>
    <table class="table">
        <tr>
            <th>Gaji Pokok</th>
            <td>Rp {{ number_format($pegawai->pegawai->gaji_pokok, 0, ',', '.') }}</td>
        </tr>
        @foreach($pegawai->pegawai->tunjangan as $tunjangan)
        <tr>
            <th>Tunjangan kehadiran</th>
            <td>Rp {{ number_format($tunjangan->kehadiran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Tunjangan Makan</th>
            <td>Rp {{ number_format($tunjangan->makan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Tunjangan Transportasi</th>
            <td>Rp {{ number_format($tunjangan->transportasi, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Tunjangan Lembur</th>
            <td>Rp {{ number_format($tunjangan->lembur, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Tunjangan Lainnya</th>
            <td>Rp {{ number_format($tunjangan->lainnya, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Tunjangan</th>
            <td>Rp {{ number_format($tunjangan->total_tunjangan, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <h5 class="mt-4">Potongan</h5>
    <table class="table">
        @foreach($pegawai->pegawai->potongan as $potongan)
        <tr>
            <th>Potongan Asuransi</th>
            <td>Rp -{{ number_format($potongan->asuransi, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Potongan BPJS</th>
            <td>Rp -{{ number_format($potongan->bpjs, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Potongan Absen</th>
            <td>Rp -{{ number_format($potongan->absen, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Potongan</th>
            <td>Rp -{{ number_format($potongan->total_potongan, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <h4 class="mt-4 text-center">Total Gaji: Rp {{ number_format($pegawai->total_gaji, 0, ',', '.') }}</h4>

    <div class="footer">
        <p>Terima kasih atas kerja keras Anda.</p>
    </div>
</div>
