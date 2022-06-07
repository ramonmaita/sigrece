<div>
    <div class="row">
		@can('documentos.certificados.titulo')
			<div class="col-md-6">
				<div class="card card-primary card-outline collapsed-card">
					<div class="card-header">
						<h3 class="card-title">Título</h3>
						<div class="card-tools">
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-plus"></i>
								</button>
								<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
								</button>
								<button type="button" class="btn btn-tool" data-card-widget="remove">
									<i class="fas fa-times"></i>
								</button>
							</div>
							{{-- {{ $graduando->id }} --}}
						</div>
						<!-- /.card-tools -->
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						@if ($graduando_id)
						<embed src="{{ route('panel.graduacion.documentos.titulo', [$graduando_id]) }}" type=""
						width="100%" height="500px">
						@else
							Documento no disponible
						@endif
						<!-- /.card-body -->

					</div>
					<!-- /.card -->
				</div>

			</div>
		@endcan
		@can('documentos.certificados.acta')
		<div class="col-md-6">
			<div class="card card-primary card-outline collapsed-card">
				<div class="card-header">
					<h3 class="card-title">Acta</h3>
					<div class="card-tools">
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
						{{-- {{ $graduando_id }} --}}
					</div>
					<!-- /.card-tools -->
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					@if ($graduando_id)
						<embed src="{{ route('panel.graduacion.documentos.acta', [$graduando_id]) }}" type=""
						width="100%" height="500px">
					@else
						Documento no disponible
					@endif
					<!-- /.card-body -->

				</div>
				<!-- /.card -->
			</div>

		</div>
		@endcan
		@can('documentos.certificados.autenticacion_titulo')
		<div class="col-md-6">
			<div class="card card-primary card-outline collapsed-card">
				<div class="card-header">
					<h3 class="card-title">Autenticación de Título</h3>
					<div class="card-tools">
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
						{{-- {{ $graduando_id }} --}}
					</div>
					<!-- /.card-tools -->
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					@if ($graduando_id)
					<embed src="{{ route('panel.documentos.certificados.autenticacion', [$graduando_id]) }}" type=""
						width="100%" height="500px">
					@else
						Documento no disponible
					@endif

					<!-- /.card-body -->

				</div>
				<!-- /.card -->
			</div>

		</div>
		@endcan
		@can('documentos.certificados.emision_titulo')
		<div class="col-md-6">
			<div class="card card-primary card-outline collapsed-card">
				<div class="card-header">
					<h3 class="card-title">Emisión de Título</h3>
					<div class="card-tools">
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
						{{-- {{ $graduando_id }} --}}
					</div>
					<!-- /.card-tools -->
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					@if ($graduando_id)
					<embed src="{{ route('panel.documentos.certificados.emision', [$graduando_id]) }}" type=""
						width="100%" height="500px">
					@else
						Documento no disponible
					@endif

					<!-- /.card-body -->

				</div>
				<!-- /.card -->
			</div>

		</div>
		@endcan
		@if ($graduando->pnf >= 40)
			@can('documentos.certificados.notas')
			<div class="col-md-6">
				<div class="card card-primary card-outline collapsed-card">
					<div class="card-header">
						<h3 class="card-title">Notas</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
						<!-- /.card-tools -->
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						@if ($graduando_id)
						<embed src="{{ route('panel.graduacion.documentos.notas', [$graduando_id]) }}" type=""
							width="100%" height="500px">
						@else
							Documento no disponible
						@endif

						<!-- /.card-body -->

					</div>
					<!-- /.card -->
				</div>

			</div>
			@endcan
		@endif
		@can('documentos.certificados.certificacion_programa')
		<div class="col-md-6">
			<div class="card card-primary card-outline collapsed-card">
				<div class="card-header">
					<h3 class="card-title">Certificación del Programa</h3>
					<div class="card-tools">

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<!-- /.card-tools -->
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					@if ($graduando_id)
					<embed src="{{ route('panel.documentos.certificados.certificacion', [$graduando->pnf]) }}" type=""
						width="100%" height="500px">
					@else
						Documento no disponible
					@endif

					<!-- /.card-body -->

				</div>
				<!-- /.card -->
			</div>

		</div>
		@endcan
	</div>
</div>
