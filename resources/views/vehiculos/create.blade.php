 <!-- Modal Agregar Vehículo -->
        <div class="modal fade" id="modalAgregarVehiculo" tabindex="-1" aria-labelledby="modalAgregarVehiculoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg">
            <form action="{{ route('vehiculos.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-car me-2"></i> Registrar Nuevo Vehículo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" name="placa" id="placa" class="form-control" placeholder="Ej: P123-ABC" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Ej: Carro, Moto..." required>
                    </div>

                    <div class="mb-3">
                        <label for="propietario" class="form-label">Propietario</label>
                        <input type="text" name="propietario" id="propietario" class="form-control" placeholder="Nombre del propietario" required>
                    </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Guardar Vehículo
                </button>
                </div>
            </form>
            </div>
        </div>
        </div>