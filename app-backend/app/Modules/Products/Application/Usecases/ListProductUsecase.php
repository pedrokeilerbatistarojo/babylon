<?php

namespace App\Modules\Products\Application\Usecases;

use App\Modules\Products\Domain\Models\Product;
use App\Modules\Products\Domain\Resources\ProductResource;
use App\Modules\Shared\Application\Usecases\TraitHandleListPayload;
use App\Modules\Shared\Application\Usecases\TraitSearchResult;
use App\Modules\Shared\Application\Usecases\TraitUseFilter;
use App\Modules\Shared\Contracts\UsecaseInterface;
use App\Modules\Shared\Domain\Exceptions\ValidationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListProductUsecase implements UsecaseInterface
{
    use TraitHandleListPayload;
    use TraitSearchResult;
    use TraitUseFilter;


    public function __construct(protected Product $entity) {}

    public function execute(): AnonymousResourceCollection
    {
        $result = $this->searchServiceResult($this->payload);

        Product::query()->select('*')->get();

        return ProductResource::collection($result);
    }
}
