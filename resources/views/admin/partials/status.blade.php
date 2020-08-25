<div class="status-column text-center" data-id="{{$row['id']}}" data-value="@if(is_null($row['deleted_at'])) {{1}} @else {{0}}  @endif ">
	<label>
		@if(is_null($row['deleted_at']))
			<span class="status-span" data-id="{{$row['id']}}" style="color:green">Active</span>
		@else
			<span class="status-span" data-id="{{$row['id']}}" style="color:red">Inactive</span>
		@endif
	</label>
</div>