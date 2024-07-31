 <div class="container">
     <div class="row justify-content-center">
         <div class="col-xl-5 col-lg-6 col-md-9">
             <div class="card o-hidden border-0 shadow-lg my-5">
                 <div class="card-body p-0">
                     <div class="p-5">
                         <div class="text-center mb-3 text-lg">
                             <div class="sidebar-brand d-flex align-items-center justify-content-center">
                                 <div class="sidebar-brand-icon rotate-n-15">
                                     <i class="fas fa-book-open"></i>
                                 </div>
                                 <div class="sidebar-brand-text mx-3">bblthq</div>
                             </div>
                         </div>
                         <form class="user" method="POST">
                             <div class="form-group">
                                 <label for="newPassword">Nueva Contraseña</label>
                                 <input type="password" class="form-control" name="newPassword" required>
                             </div>
                             <div class="form-group">
                                 <label for="confirmPassword">Repetir Contraseña</label>
                                 <input type="password" class="form-control" name="confirmPassword" required>
                             </div>
                             <button type="submit" name="send" class="btn bg-custom btn-primary btn-block">Cambiar Contraseña</button>
                             <?php
                                if (isset($_POST['send'])) {
                                    $controller = new UserController();
                                    $controller->changePasswordStart();
                                }
                                ?>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>