<?php

namespace App\Http\Controllers\Admin\DataTables;

use App\Base\Controllers\DataTableController;
use App\Models\User;
use Illuminate\Support\Facades\Log;
class UserDataTable extends DataTableController
{
    /**
     * @var string
     */
    protected $model = User::class;

    /**
     * Columns to show
     *
     * @var array
     */
    protected $columns = ['id','is_active','full_name','phone','email'];

    /**
     * @var bool
     */
    protected $ops = true;

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $users = User::query();
        return $this->applyScopes($users);
    }
}
