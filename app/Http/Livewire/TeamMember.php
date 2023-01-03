<?php

namespace App\Http\Livewire;

use App\Logic\SlackTeam;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;
use Livewire\Component;

class TeamMember extends Component
{
    /** @var string */
    public $position;

    public function mount(string $position, string $username)
    {
        $this->position = $position;
        $this->username = $username;
    }

    private function getTopDeskOperator(): \stdClass
    {
        return $this->topdeskClient()->get('operators', [
            'query' => 'networkLoginName=='.$this->username,
        ])->throw()->object()[0];
    }

    private function getIncidents(): Collection
    {
        return Cache::remember('getIncidents4'.$this->username, now()->addMinute(), function () {
            return $this->topdeskClient()->get('incidents', [
                'query' => 'closed==false;operator.id=='.$this->getTopDeskOperator()->id,
                'pageSize' => 10000,
            ])->throw()->collect();
        });
    }

    private function getCloses(): Collection
    {
        return Cache::remember('getCloses4'.$this->username, now()->addMinute(), function () {
            return $this->topdeskClient()->get('incidents', [
                'query' => 'closed==true;operator.id=='.$this->getTopDeskOperator()->id,
                'sort:desc' => 'closedDate',
                'page_size' => 10000,
            ])->throw()->collect();
        });
    }

    private function getMostRecentClose(): object
    {
        $array = $this->getCloses()
                      ->sortByDesc('closedDate')
                      ->first();

        $array['closedDate'] = Carbon::parse($array['closedDate']);

        return (object) $array;
    }

    private function getUpdated(): Collection
    {
        return $this->getIncidents()
                    ->where('processingStatus.name', '=', 'Updated by user')
                    ->pluck('modificationDate')->map(function ($item) {
                        return Carbon::parse($item);
                    })->sortDesc();
    }

    private function counts()
    {
        return [
            'Open' => $this->getIncidents()->count(),
            'Waiting for user' => $this->getIncidents()->where('processingStatus.name', '=',
                'Waiting for user')->count(),
            'Updated by user' => $this->getIncidents()->where('processingStatus.name', '=', 'Updated by user')->count(),
            'Scheduled' => $this->getIncidents()->where('processingStatus.name', '=', 'Scheduled')->count(),
        ];
    }

    private function topdeskClient(): PendingRequest
    {
        return Http::acceptJson()->withBasicAuth(
            config('topdesk.application_username'),
            config('topdesk.application_password'),
        )->baseUrl('https://servicedesk.cranleigh.org/tas/api');
    }

    private function getSquarePhoto(): string
    {
        if (is_array($this->getSlack())) {
            $image = $this->getSlack()['avatar'];
        } else {
            $image = $this->getPerson()->photo_uri;
        }
        try {
            return Image::make($image)
                        ->resize(300, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->crop(300, 300)
                        ->encode('data-url')
                        ->getEncoded();
        } catch (NotReadableException $exception) {
            return Image::make('https://www.gbguardians.com/wp-content/uploads/2021/08/Cranleigh.jpg')
                        ->resize(300, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->crop(300, 300)
                        ->encode('data-url')
                        ->getEncoded();
        }
    }

    private function getPerson(): object
    {
        if (strtolower($this->username) === 'tnscsupport') {
            return (object) [
                'photo_uri' => 'https://www.tnsc.co.uk/wp-content/uploads/2016/12/logo-yellow-light.png',
                'job_titles' => [
                    'Help',
                ],

            ];
        }

        return Cache::remember('get'.$this->username, now()->addDay(), function () {
            $response = Http::get('https://people.cranleigh.org/api/v1/person/'.$this->username)->throw()->object();

            return $response->data[0];
        });
    }

    private function getSlack(): ?array
    {
        $slackTeam = new SlackTeam();

        return $slackTeam->get()->where('username', '=', $this->username)->first();
    }

    public function render()
    {
        return view('team-member', [
            'slack' => $this->getSlack(),
            'username' => $this->username,
            'imageData' => $this->getSquarePhoto(),
            'counts' => $this->counts(),
            'incidents' => $this->getIncidents(),
            'recentUpdate' => $this->getUpdated()->first(),
            'recentClose' => $this->getMostRecentClose(),
        ]);
    }
}
