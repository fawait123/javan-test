<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use Illuminate\Support\Facades\DB;

class FamilyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/family/child/budi",
     *     tags={"Family"},
     *     summary="Find child budi",
     *     description="look for data on the child from Budi",
     *     operationId="child",
     *     deprecated=false,
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */
    public function child()
    {
       $arr = collect([]);
       $data = Family::where('name','Budi')->get();
       foreach($data as $key){
        $findChild =  Family::where('parentID',$key->id)->get();
        $arr->push([
            'id'=>$key->id,
            'name'=>$key->name,
            'child'=>$findChild
        ]);
       }
       return response()->json($arr,200);
    }

    /**
     * @OA\Get(
     *     path="/api/family/grandchild/budi",
     *     tags={"Family"},
     *     summary="Find child budi",
     *     description="look for data on the child from Budi",
     *     operationId="grandchild",
     *     deprecated=false,
      *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="Gender filter",
     *         required=false,
     *         explode=true,
     *         @OA\Schema(
     *             default="available",
     *             type="string",
     *             enum={"laki-laki", "perempuan"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */
    public function grandchild(Request $request)
    {
        $arr = collect([]);
        $data = Family::where('name','Budi')->get();
        foreach($data as $key){
        $child = collect([]);
        $findChild =  Family::where('parentID',$key->id)->get();
         foreach($findChild as $childs){
            $grandChild = Family::query();
            $grandChild = $grandChild->where('parentID',$childs->id);
            if($request->filled('gender')){
                $grandChild = $grandChild->where('gender',$request->gender);
            }
            $grandChild = $grandChild->get();
            foreach($grandChild as $grandC){
                $child->push([
                    'id'=>$grandC->id,
                    'name'=>$grandC->name,
                    'gender'=>$grandC->gender
                ]);
            }
         }
         $arr->push([
             'id'=>$key->id,
             'name'=>$key->name,
             'gender'=>$key->gender,
             'grandchild'=>$child
         ]);
        }
        return response()->json($arr,200);
    }


    /**
     * @OA\Get(
     *     path="/api/family/cousin/hani",
     *     tags={"Family"},
     *     summary="Find child budi",
     *     description="look for data on the child from Budi",
     *     operationId="cousin",
     *     deprecated=false,
           *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="Gender filter",
     *         required=false,
     *         explode=true,
     *         @OA\Schema(
     *             default="available",
     *             type="string",
     *             enum={"laki-laki", "perempuan"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */
    public function cousin(Request $request)
    {
        $arr = collect([]);
        $data = Family::where('name','Budi')->get();
        foreach($data as $key){
        $child = collect([]);
        $findChild =  Family::where('parentID',$key->id)->get();
         foreach($findChild as $childs){
            $grandChild = Family::query();
            $grandChild = $grandChild->where('parentID',$childs->id);
            if($request->filled('gender')){
                $grandChild = $grandChild->where('gender',$request->gender);
            }
            $grandChild = $grandChild->get();
            foreach($grandChild as $grandC){
                $arr->push([
                    'id'=>$grandC->id,
                    'name'=>$grandC->name,
                    'gender'=>$grandC->gender
                ]);
            }
         }
        //  $arr->push([
        //      'id'=>$key->id,
        //      'name'=>$key->name,
        //      'gender'=>$key->gender,
        //      'grandchild'=>$child
        //  ]);
        }
        return response()->json($arr,200);
    }


    /**
     * @OA\Get(
     *     path="/api/family",
     *     tags={"Family"},
     *     summary="Find child budi",
     *     description="look for data on the child from Budi",
     *     operationId="families",
     *     deprecated=false,
           *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="Gender filter",
     *         required=false,
     *         explode=true,
     *         @OA\Schema(
     *             default="available",
     *             type="string",
     *             enum={"laki-laki", "perempuan"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */
    public function families(Request $request)
    {
        $arr = collect([]);
        $data = Family::where('parentID',null)->get();
        foreach($data as $key){
        $child = collect([]);
        $findChild =  Family::where('parentID',$key->id)->get();
         foreach($findChild as $childs){
            $grandChild = Family::query();
            $grandChild = $grandChild->where('parentID',$childs->id);
            $grandChild = $grandChild->get();
            $child->push([
                'id'=>$childs->id,
                'name'=>$childs->name,
                'gender'=>$childs->gender,
                'grandChild'=>$grandChild
            ]);
         }
         $arr->push([
             'id'=>$key->id,
             'name'=>$key->name,
             'gender'=>$key->gender,
             'child'=>$child
         ]);
        }
        return response()->json($arr,200);
    }
}
