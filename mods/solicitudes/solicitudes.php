<div class="container">
    <h3>Solicitudes de pr&eacute;stamo</h3>
    <div class="row">
        <div class="col">
            <fieldset>
                <label class="form-label" for="observaciones">Mostrar solicitudes desde fecha:</label>
                <input class="form-control form-control-sm" id="fechaDesde" name="fechaDesde" type="date" required>
            </fieldset>
        </div>
        <div class="col">
            <label class="form-label" for="observaciones">Ver solicitudes con estado:</label>
            <select class="form-select form-select-sm" name="filtroEstado" id="filtroEstado"></select>
        </div>
        <div class="col align-self-end">
            <input class="btn btn-sm btn-secondary" type="button" id="btnFiltrar" value="Aplicar filtros">
        </div>
    </div>
    <div class="table-responsive small">
        <table class="table table-sm small" id="table" data-unique-id="id" data-pagination="true" data-page-size="25">
            <thead>
                <tr>
                    <th data-field="id" data-visible="false">id</th>
                    <th data-field="correlativo">Correlativo</th>
                    <th data-field="fecharecepcion">Fecha de recepci&oacute;n</th>
                    <th data-field="apellidos">Apellidos</th>
                    <th data-field="nombres">Nombres</th>
                    <th data-field="trabajo">Lugar de trabajo</th>
                    <th data-field="dui">DUI</th>
                    <th data-field="telefono">Tel&eacute;fono</th>
                    <th data-field="correo">Correo</th>
                    <th data-field="estado">Estado</th>
                    <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents"></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="solModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Solicitud correlativo: <span id="correlativoTitulo"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body small">
                <div class="row border-bottom">
                    <div class="col">Fecha de recepción
                        <strong>
                            <p id="fechaRecepcion"></p>
                        </strong>
                        <span id="id" style="display: none;"></span>
                    </div>
                    <div class="col"></div>
                    <div class="col">Estado
                        <strong>
                            <p id="estado"></p>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col">Nombres
                        <strong>
                            <p id="nombres"></p>
                        </strong>
                    </div>
                    <div class="col">Apellidos
                        <strong>
                            <p id="apellidos"></p>
                        </strong>
                    </div>
                    <div class="col">Fecha de nacimiento
                        <strong>
                            <p id="fechaNacimiento"></p>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col">Teléfono
                        <strong>
                            <p id="telefono"></p>
                        </strong>
                    </div>
                    <div class="col">Correo electrónico
                        <strong>
                            <p id="correoElectronico"></p>
                        </strong>
                    </div>
                    <div class="col">Documento de identidad
                        <strong>
                            <p id="documento"></p>
                        </strong>
                    </div>
                </div>
                <div class="row border-bottom mb-2">
                    <div class="col-8">Dirección de domicilio
                        <strong>
                            <p id="direccionDomicilio"></p>
                        </strong>
                    </div>
                    <div class="col">Autorizó compartir información
                        <strong>
                            <p id="autoriza"></p>
                        </strong>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="tabDatos" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="trabajo-tab" data-bs-toggle="tab" data-bs-target="#trabajo-tab-pane" type="button" role="tab" aria-controls="trabajo-tab-pane" aria-selected="true">Trabajo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="referencia-tab" data-bs-toggle="tab" data-bs-target="#referencia-tab-pane" type="button" role="tab" aria-controls="referencia-tab-pane" aria-selected="false">Referencia personal</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="adjuntos-tab" data-bs-toggle="tab" data-bs-target="#adjuntos-tab-pane" type="button" role="tab" aria-controls="adjuntos-tab-pane" aria-selected="false">Adjuntos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial-tab-pane" type="button" role="tab" aria-controls="historial-tab-pane" aria-selected="false">Historial de cambios</button>
                    </li>
                </ul>
                <div class="tab-content" id="tabDatosContent">
                    <div class="tab-pane fade show active" style="min-height: 140px;" id="trabajo-tab-pane" role="tabpanel" aria-labelledby="trabajo-tab" tabindex="0">
                        <div class="row mt-2">
                            <div class="col">Lugar de trabajo
                                <strong>
                                    <p id="trabajo"></p>
                                </strong>
                            </div>
                            <div class="col">Teléfono de trabajo
                                <strong>
                                    <p id="telefonoTrabajo"></p>
                                </strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">Dirección de trabajo
                                <strong>
                                    <p id="direccionTrabajo"></p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" style="min-height: 140px;" id="referencia-tab-pane" role="tabpanel" aria-labelledby="referencia-tab" tabindex="0">
                        <div class="row mt-2">
                            <div class="col">Referencia personal
                                <strong>
                                    <p id="referencia"></p>
                                </strong>
                            </div>
                            <div class="col">Teléfono de referencia personal
                                <strong>
                                    <p id="telefonoReferencia"></p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="adjuntos-tab-pane" style="min-height: 140px;" role="tabpanel" aria-labelledby="adjuntos-tab" tabindex="0">
                        <div class="list-group mt-2">
                            <a class="list-group-item list-group-item-action list-group-item-light" id="linkConsentimiento" href="#" target="_blank"><div class="row"><div class="col">Consentimiento</div><div class="col text-center"><i class="bi bi-eye"></i></div></div></a>
                            <a class="list-group-item list-group-item-action list-group-item-light" id="linkDuiFrente" href="#" target="_blank"><div class="row"><div class="col">DUI (Frente)</div><div class="col text-center"><i class="bi bi-eye"></i></div></div></a>
                            <a class="list-group-item list-group-item-action list-group-item-light" id="linkDuiAtras" href="#" target="_blank"><div class="row"><div class="col">DUI (Atrás)</div><div class="col text-center"><i class="bi bi-eye"></i></div></div></a>
                            <a class="list-group-item list-group-item-action list-group-item-light" id="linkRecibo" href="#" target="_blank"><div class="row"><div class="col">Recibo</div><div class="col text-center"><i class="bi bi-eye"></i></div></div></a>
                        </div>
                    </div>
                    <div class="tab-pane fade overflow-auto" style="height: 140px;" id="historial-tab-pane" role="tabpanel" aria-labelledby="historial-tab" tabindex="0">
                        <div class="table-responsive border-top">
                            <table class="table table-sm small mt-2 " id="tableCambios" data-toggle="tableCambios">
                                <thead>
                                    <tr>
                                        <th data-field="fechaHora">Fecha/hora</th>
                                        <th data-field="estado">Estado</th>
                                        <th data-field="observacion">Observaciones</th>
                                        <th data-field="usuario">Usuario</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                <form id="formSolicitud">
                    <div class="row py-2 small bg-light border-top mt-2">
                        <div class="col">
                            <fieldset>
                                <label class="form-label" for="cambiarEstado">Cambiar estado</label>
                                <select class="form-select form-select-sm" name="cambiarEstado" id="cambiarEstado"></select>
                            </fieldset>
                        </div>
                        <div class="col">
                            <fieldset>
                                <label class="form-label" for="observaciones">Observaciones</label>
                                <textarea class="form-control form-contro-sm" name="observaciones" id="observaciones" maxlength="350" required></textarea>
                            </fieldset>
                        </div>
                        <div class="col align-self-center text-center">
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