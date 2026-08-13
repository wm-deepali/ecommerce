<div class="table-responsive">
  <table class="table table-striped table-hover">

    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Date</th>
        <th width="120">Action</th>
      </tr>
    </thead>

    <tbody>
      @forelse($items as $item)
        <tr>

          <td>
            {{ $item->name 
                ?? $item->owner_name 
                ?? $item->company 
                ?? '-' }}
          </td>

          <td>{{ $item->email ?? '-' }}</td>

          <td>{{ $item->created_at->format('d M Y') }}</td>

          <td>
            <div class="d-flex gap-2">

              <!-- ✅ VIEW -->
              <a href="{{ route($route . '.show', $item->id) }}"
                 class="btn btn-sm btn-info text-white">
                <i class="fa fa-eye"></i>
              </a>

              <!-- ✅ DELETE -->
            <button onclick="deleteEnquiry({{ $item->id }}, '{{ $route }}')"
        class="btn btn-sm btn-danger">
    <i class="fa fa-trash"></i>
</button>
            </div>
          </td>

        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center text-muted py-3">
            No data found
          </td>
        </tr>
      @endforelse
    </tbody>

  </table>
</div>