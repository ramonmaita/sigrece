<div class="flex space-x-1">
	<a href="{{ route('panel.estudiantes.becas.edit', [$id]) }}" class="btn btn-primary btn-sm" role="button">
		<i class="fas fa-edit" aria-hidden="true"></i>
	</a>
	<form action="{{ route('panel.estudiantes.becas.destroy', [$id]) }}" method="POST">
		@method('DELETE')
		@csrf
		<button onclick="return confirm('¿Desea retirar esta beca?')" type="submit" class="btn btn-danger btn-sm" role="button">
			<i class="fas fa-trash" aria-hidden="true"></i>
		</button>
	</form>
</div>
