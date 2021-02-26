<div class="ui basic segment right aligned" style="padding-right: 0 !important">
	@if ($paginator->hasPages())
	<div class="ui pagination menu">
		{{-- Previous Page Link --}}
		@if ($paginator->onFirstPage())
		<a class="item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
			&lsaquo;
		</a>
		@else
		<a dusk="previousPage" class="item" wire:click="previousPage" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')">
			&lsaquo;
		</a>
		@endif
		
		{{-- Pagination Elements --}}
		@foreach ($elements as $element)
		{{-- "Three Dots" Separator --}}
		@if (is_string($element))
		<a class="item disabled" aria-disabled="true">{{ $element }}</a>
		@endif
		
		{{-- Array Of Links --}}
		@if (is_array($element))
		@foreach ($element as $page => $url)
		@if ($page == $paginator->currentPage())
		<a class="item active" wire:key="paginator-page-{{ $page }}" aria-current="page">{{ $page }}</a>
		@else
		<div wire:key="paginator-page-{{ $page }}">
			<a class="item" wire:click="gotoPage({{ $page }})">{{ $page }}</a>
		</div>
		@endif
		@endforeach
		@endif
		@endforeach
		
		{{-- Next Page Link --}}
		@if ($paginator->hasMorePages())
		
		<a dusk="nextPage" class="item" wire:click="nextPage" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')">
			&rsaquo;
		</a>
		
		@else
		<a class="item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
			&rsaquo;
		</a>
		@endif
	</div>
	@endif
</div>
