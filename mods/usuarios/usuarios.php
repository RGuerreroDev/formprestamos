
    <div class="container">
        <h3>Usuarios de aplicaci&oacute;n</h3>
        <div class="row mt-2">
            <div class="col">
                <button class="btn btn-sm btn-secondary" id="btnCrear"><i class="bi bi-person-plus"></i> Crear usuario</button>
            </div>
            <div class="col buttons-toolbar d-flex align-items-end flex-column"></div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-sm small"
                id="table"
                data-unique-id="id"
                data-search="true"
                data-buttons-toolbar=".buttons-toolbar"
                data-pagination="true"
                data-page-size="25">
                <thead>
                    <tr>
                        <th data-field="id" data-visible="false">id</th>
                        <th data-field="usuario">Usuario</th>
                        <th data-field="nombrecompleto">Nombre completo</th>
                        <th data-field="activo">Activo</th>
                        <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="usrModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Usuario: <span id="usuarioTitle"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body small">
                    <form id="formUsuario">
                        <div class="row py-2 small">
                            <div class="col">
                                <fieldset>
                                    <label class="form-label" for="nombreCompleto">Nombre completo</label>
                                    <input class="form-control form-control-sm" name="nombreCompleto" id="nombreCompleto" maxlength="100" required>
                                </fieldset>
                            </div>
                            <div class="col">
                                <fieldset>
                                    <label class="form-label" for="usuario">Usuario</label>
                                    <input class="form-control form-control-sm" name="usuario" id="usuario" maxlength="50" required>
                                </fieldset>
                            </div>
                            <div class="col">
                                <fieldset>
                                    <label class="form-label" for="contrasena">Contrase&ntilde;a</label>
                                    <input type="password" class="form-control form-control-sm" name="contrasena" id="contrasena" maxlength="25" required>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row py-2 small">
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label" for="activo">Activo</label>
                                    <input type="checkbox" class="form-check-input" name="activo" id="activo" checked>
                                </div>
                            </div>
                            <div class="col"><strong>Fecha de creaci&oacute;n</strong>
                                <p id="fechaCreacion"></p>
                            </div>
                            <div class="col align-self-center">
                                <input type="hidden" id="id" name="id" value="">
                                <input class="btn btn-sm btn-primary" type="submit" value="Guardar">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Resultado de guardar datos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <span id="resultado"></span>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
