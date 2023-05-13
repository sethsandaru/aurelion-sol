<?php

namespace App\Console\Commands;

use App\Services\ETL\RawHotel;
use App\Services\HotelServices\HotelServiceContract;
use App\Services\HotelServices\RainyHotelService;
use App\Services\HotelServices\SunnyHotelService;
use App\Services\HotelServices\WindyHotelService;
use App\Services\MergingService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class PullHotelsCommand extends Command
{
    protected $signature = 'hotels:pull';
    protected $description = 'Pull hotels from ALL SERVICES, transform and merge them then store to DB';

    public function handle(MergingService $mergingService): void
    {
        $this->getHotelServices()
            ->each(function (HotelServiceContract $service) use ($mergingService) {
                $this->info('Retrieving & Merging for Service ' . $service->getName());

                $service->getHotels()
                    ->each(fn (RawHotel $rawHotel) => $mergingService->resolve($rawHotel));

                $this->info('Finished for Service ' . $service->getName());
            });
    }

    /**
     * @return Collection<HotelServiceContract>
     */
    private function getHotelServices(): Collection
    {
        return collect([
            app(RainyHotelService::class),
            app(SunnyHotelService::class),
            app(WindyHotelService::class),
        ]);
    }
}
