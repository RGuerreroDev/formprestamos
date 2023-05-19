
    <div class="container">
        <h3>Solicitudes de pr&eacute;stamo</h3>
        <div class="table-responsive small">
            <table class="table table-sm small"
                id="table"
                data-unique-id="id"
                data-pagination="true"
                data-page-size="25">
                <thead>
                    <tr>
                        <th data-field="id" data-visible="false">id</th>
                        <th data-field="correlativo">Correlativo</th>
                        <th data-field="fecharecepcion">Fecha de recepci&oacute;n</th>
                        <th data-field="apellidos">Apellidos</th>
                        <th data-field="nombres">Nombres</th>
                        <th data-field="trabajo">Lugar de trabajo</th>
                        <th data-field="ingreso" data-formatter="$ %s">Ingreso</th>
                        <th data-field="estado">Estado</th>
                        <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="solModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Solicitud correlativo: <span id="correlativoTitulo"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body small">
                    <div class="row border-bottom">
                        <div class="col"><strong>Fecha de recepción</strong>
                            <p id="fechaRecepcion"></p>
                            <span id="id" style="display: none;"></span>
                        </div>
                        <div class="col"></div>
                        <div class="col"><strong>Estado</strong>
                            <p id="estado"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><strong>Apellidos y Nombres</strong>
                            <p id="apellidosNombres"></p>
                        </div>
                        <div class="col"><strong>Fecha de nacimiento</strong>
                            <p id="fechaNacimiento"></p>
                        </div>
                        <div class="col"><strong>Documento de identidad</strong>
                            <p id="documento"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><strong>Teléfono</strong>
                            <p id="telefono"></p>
                        </div>
                        <div class="col"><strong>Correo electrónico</strong>
                            <p id="correoElectronico"></p>
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row border-bottom">
                        <div class="col"><strong>Lugar de trabajo</strong>
                            <p id="trabajo"></p>
                        </div>
                        <div class="col"><strong>Ingreso mensual</strong>
                            <p>$ <span id="ingreso"></span></p>
                        </div>
                        <div class="col"><strong>Firma</strong>
                            <img id="firma" src="" style="max-width: 200px;">
                        </div>
                    </div>
                    <form id="formSolicitud">
                        <div class="row py-2 small">
                            <div class="col">
                                <fieldset>
                                    <label class="form-label" for="cambiarEstado">Cambiar estado</label>
                                    <select class="form-select form-select-sm" name="cambiarEstado" id="cambiarEstado"></select>
                                </fieldset>
                            </div>
                            <div class="col">
                                <fieldset>
                                    <label class="form-label" for="observaciones">Observaciones</label>
                                    <textarea class="form-control form-contro-sm" name="observaciones" id="observaciones"></textarea>
                                </fieldset>
                            </div>
                            <div class="col align-self-center">
                                <input class="btn btn-sm btn-primary" type="submit" value="Guardar">
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive border-top">
                        <h6>Historial de cambios</h6>
                        <table class="table table-sm small"
                            id="tableCambios"
                            data-toggle="tableCambios">
                            <thead>
                                <tr>
                                    <th data-field="fechaHora">Fecha/hora</th>
                                    <th data-field="estado">Estado</th>
                                    <th data-field="observacion">Observaci&oacute;n</th>
                                    <th data-field="usuario">Usuario</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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
                <h5 class="modal-title" id="staticBackdropLabel">Resultado de actualizaci&oacute;n de datos</h5>
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
