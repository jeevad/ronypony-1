<?php

namespace App\Http\Controllers\User;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Responses\BadResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Http\Responses\SuccessResponse;
use App\Http\Responses\UnauthorizedResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressController extends Controller
{
    /**
     * Display a listing of the user addresses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user('api');

        $addresses = Address::with('user')
            ->whereUserId($user->id)
            ->paginate();
        if ($addresses->total() === 0) {
            throw new ModelNotFoundException(trans('alerts.records_not_found'));
        }

        return AddressResource::collection($addresses);
    }

    /**
     * Store a newly created user addresses in database.
     *
     * @param \App\Http\Requests\AddressRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        $user = $request->user('api');
        $data = $request->toBag()->attributes();
        $addressCount = Address::whereUserId($user->id)->count();
        if ($addressCount === 0) {
            $data['default'] = true;
        }
        $address = $user->addresses()->create($data);

        return new AddressResource($address->fresh());
    }

    /**
     * Update the specified user addresses in database.
     *
     * @param \App\Http\Requests\AddressRequest $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, Address $address)
    {
        $data = $request->toBag()->attributes();
        $address->update($data);

        return new AddressResource($address);
    }

    /**
     * Delete the specified user addresses from database.
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if ($address->default) {
            return new BadResponse('Default address can not be deleted');
        }
        return new SuccessResponse('Address deleted');
    }

    public function markAsDefault(Request $request, Address $address)
    {
        if ($address && $request->user('api')->id === $address->user_id) {
            $address = tap(Address::whereDefault(true)->first(), function ($defaultAddress) use ($address) {
                if ($defaultAddress->id !== $address->id) {
                    $defaultAddress->update(['default' => false]);
                    $address->update(['default' => true]);
                    return $address;
                }
            });
            return ((new AddressResource($address))
                ->additional(['message' => trans('Address marked as default')]));
        }
        return new UnauthorizedResponse();
    }
}
