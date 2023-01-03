<?php

namespace App\Logic;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SlackTeam
{

    protected function client(): PendingRequest
    {
        return Http::withToken(
            config('services.slack.token')
        )->baseUrl('https://slack.com/api/');
    }

    private function getTeamUsers(): array
    {
        return Cache::remember('teamUsers'.config('services.slack.teamId'), now()->addDay(), function () {
            $users = $this->client()
                          ->get('usergroups.users.list', [
                              'usergroup' => config('services.slack.teamId'),
                          ])
                          ->throw()
                          ->collect();
            return $users[ 'users' ];
        });
    }

    public function get(): Collection
    {
        $data = [];
        foreach ($this->getTeamUsers() as $userId) {
            $response = Cache::remember('getSlackUserProfile.'.$userId, now()->addMinutes(2.5),
                function () use ($userId) {
                    return $this->client()
                                ->get('users.profile.get', [
                                    'user' => $userId,
                                ])
                                ->throw()
                                ->object();
                });

            if ($response->ok === true) {
                $data[] = $response->profile;
            }
        }

        return collect($data)->map(function ($item) {
            return [
                'username' => strtoupper($item->display_name_normalized),
                'surname' => $item->last_name,
                'status_text' => $item->status_text,
                'emoji' => $item->status_emoji,
                'avatar' => $item->image_512,
            ];
        })->sortBy('surname');
    }


}
