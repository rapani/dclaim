<main role="main" class="container-fluid">
<br>
<br>
<br>

<div class="card">
  <h5 class="card-header">DOCUMENT E-CLAIM RAWAT INAP</h5>
  <div class="card-body">


    <table   class="display" id="rjtl" style="width:100%">
      <thead class="table-danger">
        <tr>
        <th scope="col">#</th>
          <th scope="col">NAMA PASIEN</th>
          <th scope="col">NO. KARTU</th>
          <th scope="col">NOMOR SEP</th>
          <th scope="col">TGL SEP</th>
          <th scope="col">BIL</th>
          <th scope="col">LIP</th>
          <th scope="col">CAM</th>
          <th scope="col">VERIF</th>
          <th scope="col">UPLOAD</th>
        </tr>
      </thead>

    </table>



</div>
</div>
</main>



<footer class="footer">
  <div class="container">
    <span class="text-muted">Digital Claim RSI Ibnu Sina Bukittinggi - Version 1.0</span>
  </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="./assets/jquery-3.3.1.js"></script>
<script src="./datatables/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="./assets/popper.min.js"></script>
<script src="./assets/bootstrap.min.js"></script>
</body>
</html>

<script>
            $(document).ready(function () {
                $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
                {
                    return {
                        "iStart": oSettings._iDisplayStart,
                        "iEnd": oSettings.fnDisplayEnd(),
                        "iLength": oSettings._iDisplayLength,
                        "iTotal": oSettings.fnRecordsTotal(),
                        "iFilteredTotal": oSettings.fnRecordsDisplay(),
                        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                    };
                };

                var t = $('#rjtl').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [20, 40, 60, 80, 100,500,1000,2000],
                    "pageLength": 20,
                    "ajax": 'konten/data2.php',
                    "columnDefs": [
                        {"className": "dt-center", "targets": [ 0,5,6,7,8,9 ]} 
                    ],

                    "columns": [
                        {
                            "data": null,
                            "orderable": false
                        },
                        
                        {"data": "nama_pasien"},
                        {"data": "no_kar"},
                        {"data": "no_sep"},
                        {"data": "tgl_sep"},
                        {"data": "pdf_billing"},
                        {"data": "pdf_individual"},
                        {"data": "pdf_camscan"},
                        {"data": "verif"},
                        {"data": "aksi"}
                        
                    ],
                    "order": [[4, 'desc']],
                    "rowCallback": function (row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
            });
        </script>
