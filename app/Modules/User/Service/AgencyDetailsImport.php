<?php

namespace App\Modules\User\Service;


use App\Models\AgencyDetails;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class AgencyDetailsImport implements ToCollection, WithMultipleSheets
{

    public function collection(Collection $collection)
    {
        try {
            \DB::beginTransaction();
            foreach ($collection as $key => $item) {
                if ($key >= 1) {
                    $username = $item[1];
                    $user = User::where('username', $username)->first();
                    if ($user) {
                        $agencyDetails = new AgencyDetails();
                        $agencyDetails->agency = $item[1];
                        $agencyDetails->player_username = $item[2];
                        $agencyDetails->full_name = $item[3];
                        $agencyDetails->phone = $item[4];
                        $agencyDetails->month = $item[5];
                        $agencyDetails->logout_days = $item[6];
                        $agencyDetails->total_money = $item[7];
                        $agencyDetails->save();
                    }
                }
            }
            \DB::commit();
            return true;

        } catch (\Exception $e) {
            \DB::rollBack();
        }
    }

    public
    function sheets(): array
    {
        return [
            0 => new AgencyDetailsImport,
        ];
    }
}
