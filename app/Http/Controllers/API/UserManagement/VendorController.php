<?php

namespace App\Http\Controllers\API\UserManagement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Repository\User\OtpRepository;
use Repository\Role\RoleRepository;
use Repository\User\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Users\SignUpRequest;
use App\Http\Controllers\JsonResponseTrait;
use App\Http\Resources\Vendor\VendorResource;

class VendorController extends Controller
{
    use JsonResponseTrait;

    public $vendorRepo;
    public $otpRepo;
    public $roleRepo;

    public function __construct(UserRepository $vendorRepository, OtpRepository $otpRepository, RoleRepository $roleRepository)
    {
        $this->vendorRepo = $vendorRepository;
        $this->otpRepo  = $otpRepository;
        $this->roleRepo  = $roleRepository;
    }

    public function index($shop_id)
    {
        $staffs  = $this->vendorRepo->findStaffByVendor(Auth::id(),$shop_id);
        return $this->json('Staff list', $staffs);
    }

    public function store(Request $request)
    {
        $user = DB::transaction(function () use ($request) {
            if($this->vendorRepo->model()::where('phone_number', '=', $request->phone_number)->exists())
            {
                $this->vendorRepo->createStaffByVendorID($request->user_id,$request->all());
            }
            else
            {
                $user = $this->vendorRepo->create($request->all()+ [
                    'role_id'   =>  $this->roleRepo->getRoleForShopMember()->id
                ]);
                $this->vendorRepo->updateOrNewBy($user);
                $userOtp = $this->otpRepo->generateOtpForUser($user);
                $this->vendorRepo->createStaffByVendorID($user->id,$request->all());
                return compact('user', 'userOtp');
            }
            return $this->json('User registered successfully. Please check your email or phone to active account');
        });
    }

    public function show($id)
    {
        $user       = $this->vendorRepo->findByID($id);
        $message    = $user->name." Hello!";
        return $this->json($message,[VendorResource::make($user)]);
    }

    public function update(Request $request, $id)
    {
        $user = $this->vendorRepo->findByID($id);
        $user = $this->vendorRepo->updateByID($id,$request->all());
        return $this->json('Updated You Info',[VendorResource::make($user)]);
    }

    public function searchMember(Request $request) {
        $member = $this->vendorRepo->getSearchMember($request['keyword']);
        return $this->json('User Member', $member);
    }

    public function destroy($id)
    {
        $user       = $this->vendorRepo->deleteByID($id);
        $message    =" Staff Deleted!";
        return $this->json($message, $user);
    }
}
