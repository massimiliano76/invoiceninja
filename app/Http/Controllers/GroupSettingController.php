<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2019. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Http\Controllers;


use App\Factory\GroupSettingFactory;
use App\Http\Requests\GroupSetting\CreateGroupSettingRequest;
use App\Http\Requests\GroupSetting\DestroyGroupSettingRequest;
use App\Http\Requests\GroupSetting\EditGroupSettingRequest;
use App\Http\Requests\GroupSetting\ShowGroupSettingRequest;
use App\Http\Requests\GroupSetting\StoreGroupSettingRequest;
use App\Http\Requests\GroupSetting\UpdateGroupSettingRequest;
use App\Models\GroupSetting;
use App\Repositories\GroupSettingRepository;
use App\Transformers\GroupSettingTransformer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

class GroupSettingController extends BaseController
{
    use DispatchesJobs;

    protected $entity_type = GroupSetting::class;

    protected $entity_transformer = GroupSettingTransformer::class;

    protected $group_setting_repo;

    public function __construct(GroupSettingRepository $group_setting_repo)
    {
        parent::__construct();

        $this->group_setting_repo = $group_setting_repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * 
     * @OA\Get(
     *      path="/api/v1/group_settings",
     *      operationId="getGroupSettings",
     *      tags={"group_settings"},
     *      summary="Gets a list of group_settings",
     *      description="Lists group_settings, search and filters allow fine grained lists to be generated.

        Query parameters can be added to performed more fine grained filtering of the group_settings, these are handled by the GroupSettingFilters class which defines the methods available",
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Secret"),
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Token"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Response(
     *          response=200,
     *          description="A list of group_settings",
     *          @OA\Header(header="X-API-TOKEN", ref="#/components/headers/X-API-TOKEN"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/GroupSetting"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),

     *       ),
     *       @OA\Response(
     *           response="default", 
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     *
     */
    public function index()
    {
        $group_settings = GroupSetting::whereCompanyId(auth()->user()->company()->id);

        return $this->listResponse($group_settings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     * 
     * 
     * @OA\Get(
     *      path="/api/v1/group_settings/create",
     *      operationId="getGroupSettingsCreate",
     *      tags={"group_settings"},
     *      summary="Gets a new blank GroupSetting object",
     *      description="Returns a blank object with default values",
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Secret"),
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Token"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Response(
     *          response=200,
     *          description="A blank GroupSetting object",
     *          @OA\Header(header="X-API-TOKEN", ref="#/components/headers/X-API-TOKEN"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/GroupSetting"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default", 
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     *
     */
    public function create(CreateGroupSettingRequest $request)
    {
        $group_setting = GroupSettingFactory::create(auth()->user()->company()->id, auth()->user()->id);

        return $this->itemResponse($group_setting);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SignupRequest $request
     * @return \Illuminate\Http\Response
     *
     *
     *
     * @OA\Post(
     *      path="/api/v1/group_settings",
     *      operationId="storeGroupSetting",
     *      tags={"group_settings"},
     *      summary="Adds a GroupSetting",
     *      description="Adds an GroupSetting to the system",
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Secret"),
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Token"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the saved GroupSetting object",
     *          @OA\Header(header="X-API-TOKEN", ref="#/components/headers/X-API-TOKEN"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/GroupSetting"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default", 
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     *
     */
    public function store(StoreGroupSettingRequest $request)
    {
        //need to be careful here as we may also receive some
        //supporting attributes such as logo which need to be handled outside of the
        //settings object
        $group_setting = GroupSettingFactory::create(auth()->user()->company()->id, auth()->user()->id);

        $group_setting = $this->group_setting_repo->save($request->all(), $group_setting);
        
        return $this->itemResponse($group_setting);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     *
     * @OA\Get(
     *      path="/api/v1/group_settings/{id}",
     *      operationId="showGroupSetting",
     *      tags={"group_settings"},
     *      summary="Shows an GroupSetting",
     *      description="Displays an GroupSetting by id",
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Secret"),
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Token"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The GroupSetting Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the GroupSetting object",
     *          @OA\Header(header="X-API-TOKEN", ref="#/components/headers/X-API-TOKEN"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/GroupSetting"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default", 
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     *
     */
    public function show(ShowGroupSettingRequest $request, GroupSetting $group_setting)
    {
        return $this->itemResponse($group_setting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * 
     * @OA\Get(
     *      path="/api/v1/group_settings/{id}/edit",
     *      operationId="editGroupSetting",
     *      tags={"group_settings"},
     *      summary="Shows an GroupSetting for editting",
     *      description="Displays an GroupSetting by id",
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Secret"),
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Token"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The GroupSetting Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the GroupSetting object",
     *          @OA\Header(header="X-API-TOKEN", ref="#/components/headers/X-API-TOKEN"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/GroupSetting"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default", 
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     *
     */
    public function edit(EditGroupSettingRequest $request, GroupSetting $group_setting)
    {
        return $this->itemResponse($group_setting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * 
     * @OA\Put(
     *      path="/api/v1/group_settings/{id}",
     *      operationId="updateGroupSetting",
     *      tags={"group_settings"},
     *      summary="Updates an GroupSetting",
     *      description="Handles the updating of an GroupSetting by id",
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Secret"),
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Token"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The GroupSetting Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns the GroupSetting object",
     *          @OA\Header(header="X-API-TOKEN", ref="#/components/headers/X-API-TOKEN"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *          @OA\JsonContent(ref="#/components/schemas/GroupSetting"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default", 
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     *
     */
    public function update(UpdateGroupSettingRequest $request, GroupSetting $group_setting)
    {

       $group_setting = $this->group_setting_repo->save($request->all(), $group_setting);
        
        return $this->itemResponse($group_setting);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * 
     * @OA\Delete(
     *      path="/api/v1/group_settings/{id}",
     *      operationId="deleteGroupSetting",
     *      tags={"group_settings"},
     *      summary="Deletes a GroupSetting",
     *      description="Handles the deletion of an GroupSetting by id",
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Secret"),
     *      @OA\Parameter(ref="#/components/parameters/X-Api-Token"),
     *      @OA\Parameter(ref="#/components/parameters/X-Requested-With"),
     *      @OA\Parameter(ref="#/components/parameters/include"),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The GroupSetting Hashed ID",
     *          example="D2J234DFA",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns a HTTP status",
     *          @OA\Header(header="X-API-TOKEN", ref="#/components/headers/X-API-TOKEN"),
     *          @OA\Header(header="X-RateLimit-Remaining", ref="#/components/headers/X-RateLimit-Remaining"),
     *          @OA\Header(header="X-RateLimit-Limit", ref="#/components/headers/X-RateLimit-Limit"),
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError"),
     *
     *       ),
     *       @OA\Response(
     *           response="default", 
     *           description="Unexpected Error",
     *           @OA\JsonContent(ref="#/components/schemas/Error"),
     *       ),
     *     )
     *
     */
    public function destroy(DestroyGroupSettingRequest $request, GroupSetting $group_setting)
    {
        $group_setting->delete();

        return response()->json([], 200);

    }
}