       </div>
       <!-- Footer -->
       <footer class="sticky-footer bg-white">
           <div class="container my-auto">
               <div class="copyright text-center my-auto">
                   <span>copyright &copy;
                       <script>
                           document.write(new Date().getFullYear());
                       </script> - developed by
                       <b><a href="https://indrijunanda.gitlab.io/" target="_blank">indrijunanda</a></b>
                   </span>
               </div>
           </div>
       </footer>
       <!-- Footer -->
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
                       <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                       <a href="<?= base_url('Login/logout'); ?>" class="btn btn-primary">Keluar</a>
                   </div>
               </div>
           </div>
       </div>

       <!-- Scroll to top -->
       <a class="scroll-to-top rounded" href="#page-top">
           <i class="fas fa-angle-up"></i>
       </a>

       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/jquery/jquery.min.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/js/ruang-admin.min.js"></script>

       <!-- Page level plugins -->
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
       <script src="<?= base_url('assets/ruang-admin'); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

       <!-- Page level custom scripts -->
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