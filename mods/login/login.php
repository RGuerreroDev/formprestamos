        <section class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="card" style="min-width: 300px;">
                <img src="../imgs/tulogo.jpg" class="mx-auto d-block" style="max-width: 150px;">
                <div class="card-body">
                    <h5 class="card-header mb-2">Inicio de sesi&oacute;n</h5>
                    <form id="frmInicioSesion">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control form-control-sm" id="usuario" name="usuario" placeholder="usuario">
                            <label for="usuario">Usuario</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contrase&ntilde;a">
                            <label for="password">Contrase&ntilde;a</label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2" id="btnSubmit">
                            Aceptar
                            <span class="spinner-grow spinner-grow-sm visually-hidden" id="btnAceptarSpinner" role="status" aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </section>
        <div class="toast-container position-absolute p-3 top-0 start-0" id="toastPlacement">
            <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" id="toastError">
                <div class="d-flex">
                    <div class="toast-body">
                        Usuario o contrase&ntilde;a incorrectos.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
