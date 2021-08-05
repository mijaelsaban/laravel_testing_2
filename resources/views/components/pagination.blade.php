<?php
use Illuminate\Pagination\LengthAwarePaginator;
/**
 * @var LengthAwarePaginator $model
 */
?>
<div class="mt-3 d-flex justify-content-center">
    {{ $model->links() }}
</div>
