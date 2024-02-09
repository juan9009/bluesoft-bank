<?php

namespace App\Src\Providers;

use App\Models\Client;
use App\Src\DTOs\ClientDTO;
use App\Src\Repositories\ClientRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentClientRepository implements ClientRepositoryInterface
{
    public function all($search = null)
    {
        return Client::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->OrWhere('city', 'like', '%' . $search . '%');
            })
            ->orderBy('name', 'asc')
            ->paginate(10);
        //->withQueryString()
    }

    public function find($id)
    {
    }

    public function save(ClientDTO $clientDto)
    {
        $account = new Client();
        $account->name = $clientDto->getName();
        $account->city = $clientDto->getCity();
        $account->type = $clientDto->getType();
        $account->save();
    }

    public function movements()
    {
    }

    public function transactions($month)
    {
        $clients = Client::query()
            ->with([
                'accounts.deposits' => function ($query) use ($month) {
                    $query->whereMonth('created_at', Carbon::parse($month)->month);
                },
                'accounts.withdrawals' => function ($query) use ($month) {
                    $query->whereMonth('created_at', Carbon::parse($month)->month);
                }
            ])
            ->get()
            ->each(function ($client) {
                $client->transactions_count = $client->accounts->sum(function ($account) {
                    return $account->deposits->count() + $account->withdrawals->count();
                });
            });

        $clients = $clients->sortByDesc('transactions_count')->values();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $clients->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginator = new LengthAwarePaginator($currentItems, count($clients), $perPage, $currentPage);

        return $paginator;
    }

    public function outTownWithdrawal()
    {
        $withdrawalsSum = DB::table('clients')
            ->select('clients.uuid', DB::raw('SUM(withdrawals.amount) as total_amount'))
            ->join('accounts', 'clients.uuid', '=', 'accounts.client_uuid')
            ->join('withdrawals', 'accounts.uuid', '=', 'withdrawals.account_uuid')
            ->whereRaw('accounts.city != withdrawals.city')
            ->groupBy('clients.uuid')
            ->havingRaw('SUM(withdrawals.amount) > 1000000');

        $clients = Client::query()
            ->joinSub($withdrawalsSum, 'withdrawalsSum', function ($join) {
                $join->on('clients.uuid', '=', 'withdrawalsSum.uuid');
            })
            ->paginate(10);

        return $clients;
    }
}
