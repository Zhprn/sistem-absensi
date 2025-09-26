
<style>
    /* Styling untuk tabel */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    .table th, .table td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    .table th {
        background-color: #228B22; /* Warna biru untuk header */
        color: white; /* Warna teks putih */
    }

    .table tr:nth-child(even) {
        background-color: #f2f2f2; /* Warna latar belakang untuk baris genap */
    }

    .table tr:hover {
        background-color: #f1f1f1; /* Warna latar belakang saat hover */
    }

    .text-center {
        text-align: center;
    }
</style>

<table class="table table-striped" id="table-1">
    <thead>
      <tr>
        <th class="text-center">
          #
        </th>
        <th class="text-center">NIP</th>
        <th>Nama Pegawai</th>
        <th>Gender</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Jabatan</th>
        <th>Bagian</th>
        <th>Shift</th>
        
      </tr>
    </thead>
    <tbody>

      @foreach($pegawai as $no=>$data)
      <tr>
          <td class="text-center">{{ $no+1 }}</td>
          <td>{{ $data->nip }}</td>
          <td>{{ $data->nama_pegawai }}</td>
          <td>{{ $data->gender}}</td>
          <td>{{ $data->tgl_lahir }}</td>
          <td>{{ $data->alamat }}</td>
          <td>{{ $data->jabatan->jabatan }}</td>
          <td>{{ $data->bagian->bagian }}</td>
          <td>{{ $data->shift->shift }}</td>
          
      </tr>
      @endforeach
    </tbody>
  </table>

