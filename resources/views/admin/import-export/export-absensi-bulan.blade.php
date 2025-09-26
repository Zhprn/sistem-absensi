
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
<h4>Bulan : {{ $monthInputStatus }}</h4>
<table class="table table-striped" id="table-1">
    <thead>
      <tr>
       
        <th class="text-center">
          #
        </th>
        <th>NIP</th>
        <th>Nama Pegawai</th>
        <th>Jabatan</th>
        <th>Bagian</th>

        @foreach (['H', 'T', 'I', 'S', 'A'] as $_st)
          <th scope="col">
            {{ $_st }}
          </th>
        @endforeach
        
      </tr>
    </thead>
    <tbody>
        @foreach($pegawai as $no=>$dataP)
          {{-- @foreach($dataP->attendances as $dataA) --}}
          <tr>
            <td class="text-center">{{ $no+1 }}</td>
            <td>{{ $dataP->nip }}</td>
            <td>{{ $dataP->nama_pegawai }}</td>
            <td>{{ $dataP->jabatan->jabatan }}</td>
            <td>{{ $dataP->bagian->bagian }}</td>
              @php
                $presentCount = 0;
                $lateCount = 0;
                $excusedCount = 0;
                $sickCount = 0;
                $absentCount = 0;
              @endphp
              @foreach($dataMonth as $date)
                @php
                // Mencari sttus absensi untuk tanggal tertentu
                // $attendance = $dataP->attendances->firstWhere('formatted_date', $date);
                // Mengubah format tanggal untuk perbandingan
                  $currentDate = \Carbon\Carbon::createFromFormat('d/m', $date)->format('Y-m-d');
                  $dayOfWeek = \Carbon\Carbon::createFromFormat('Y-m-d', $currentDate)->dayOfWeek; // 0 = Minggu, 6 = Sabtu
                @endphp  

                @if ($dayOfWeek == 0 || $dayOfWeek == 6)
                    <!-- Jika hari Minggu (0) atau Sabtu (6), tampilkan output khusus -->
                    -
                @else
                    <!-- Cek apakah pegawai hadir pada tanggal ini -->
                    @php
                        $attendance = $dataP->attendances->firstWhere('formatted_date', $date);

                        if($attendance){
                            switch ($attendance->status) {
                                case 'present':
                                    $shortStatus = 'H';
                                    $presentCount++;
                                    break;
                                case 'late':
                                    $shortStatus = 'T';
                                    $lateCount++;
                                    break;
                                case 'excused':
                                    $shortStatus = 'I';
                                    $excusedCount++;
                                    break;
                                case 'sick':
                                    $shortStatus = 'S';
                                    $sickCount++;
                                    break;
                                case 'absent':
                                    $shortStatus = 'A';
                                    $absentCount++;
                                    break;
                                default:
                                    $shortStatus = '-';
                                    break;
                            }
                        }else {
                            $absentCount++;
                            
                        }
                        
                                    
                    @endphp
                @endif
                @endforeach
                

              @foreach ([$presentCount,$lateCount,$excusedCount,$sickCount,$absentCount] as $statusCount)
                <td style=" text-align: center;">
                  {{ $statusCount }}
                </td>
              @endforeach
          </tr>
          {{-- @endforeach --}}
        @endforeach
    </tbody>
  </table>

