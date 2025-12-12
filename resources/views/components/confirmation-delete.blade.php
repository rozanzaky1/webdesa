<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmationDelete{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationDeleteLabel{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <form action="{{ $route }}" method="POST">
                @csrf
                @method('DELETE')

                <!-- Header -->
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title d-flex align-items-center" id="confirmationDeleteLabel{{ $id }}">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span>Konfirmasi Hapus</span>
                    </h5>
                    <!-- Tombol Close (ikon silang) -->
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data penduduk berikut?</p>
                    <div class="mt-3 p-3 bg-light rounded border">
                        <strong>{{ $name }}</strong><br>
                        <small class="text-muted">NIK: {{ $nik }}</small>
                    </div>
                    <p class="text-danger mt-3 mb-0 d-flex align-items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        <small>Data yang dihapus tidak dapat dikembalikan!</small>
                    </p>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-2"></i>
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>