       </div>

       </div>
       </div>

       <!-- Modal Logout -->
       <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-body">
                       <p>Apakah anda yakin ingin keluar?</p>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Kembali</button>
                       <a href="<?= base_url('Autentikasi/logout'); ?>" style="background-color: #cc0000; border: #cc0000;" class="btn text-white">Keluar</a>
                   </div>
               </div>
           </div>
       </div>

       <!-- Scroll to top -->
       <a class="scroll-to-top rounded" href="#page-top">
           <i class="fas fa-angle-up"></i>
       </a>


       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/js/ruang-admin.min.js"></script>

       <!-- Chart -->
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/chart.js/Chart.min.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/js/demo/chart-area-demo.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/js/demo/chart-pie-demo.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/js/demo/chart-bar-demo.js"></script>


       <!-- Select2 -->
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/select2/dist/js/select2.min.js"></script>


       <!-- Page level plugins -->
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

       <!-- swall 2 -->
       <script src="<?= base_url('assets/swall2'); ?>/dist/sweetalert2.all.min.js"></script>



       <!-- Bootstrap Datepicker -->
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
       <!-- Page level custom scripts -->

       <!-- Money mask -->
       <script src="<?= base_url("assets/Mask-money/dist"); ?>/jquery.mask.min.js"></script>


       <script>
           $(document).ready(function() {
               $('#dataTable').DataTable({
                   'language': {
                       "sProcessing": "Sedang memproses...",
                       "sLengthMenu": "Tampilkan _MENU_",
                       "sZeroRecords": "Tidak ditemukan data yang sesuai",
                       "sInfo": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                       "sInfoEmpty": "Menampilkan 0 - 0 dari 0 data",
                       "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                       "sInfoPostFix": "",
                       "sSearch": "Cari : ",
                       "sUrl": "",
                       "oPaginate": {
                           "sFirst": "Pertama",
                           "sPrevious": "Sebelumnya",
                           "sNext": "Selanjutnya",
                           "sLast": "Terakhir"
                       }
                   }
               }); // ID From dataTable 



           });
       </script>

       </body>

       </html>