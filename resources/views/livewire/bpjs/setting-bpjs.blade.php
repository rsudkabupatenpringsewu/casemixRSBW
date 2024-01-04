<div>
    <table class="table table-sm" style="white-space: nowrap;">
        <thead>
            <tr>
                <th>ID</th>
                <th>No. Rekam Medis</th>
                <th>No. Rawat</th>
                <th>Nama Pasien</th>
                <th>Jenis Berkas</th>
                <th>File</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($getDataListCasemix as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->no_rkm_medis }}</td>
                    <td>{{ $item->no_rawat }}</td>
                    <td>{{ $item->nama_pasein }}</td>
                    <td>{{ $item->jenis_berkas }}</td>
                    <td>{{ $item->file }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
