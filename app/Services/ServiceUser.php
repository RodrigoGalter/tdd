<?php


namespace App\Services;


use App\Models\User;
use DB;
use Illuminate\Http\Response;

class ServiceUser
{
    private User $user;

    public function  __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return $this->user->get();
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $user = $this->user->create($request->all());

            DB::commit();
            return response()->json([
                "success" => "Registro criado com sucesso",
                "data" => compact($user)
            ], Response::HTTP_CREATED
            );

        }catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['errors' => $exception->getMessage()],403);
        }
    }

    public function update($request, $user)
    {
        try {

            DB::beginTransaction();

            $this->user->find($user)->update($request->all());

            DB::commit();
            return response()->json(["success" => "Registro atualizado com sucesso"],202);

        }catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['errors' => $exception->getMessage()],403);
        }
    }

    public function destroy($user)
    {

        try {

            DB::beginTransaction();

            $result = $this->user->findOrFail($user);

            $result->users_x_pathology()->delete();
            $result->delete();


            DB::commit();
            return response()->json(["success" => "Registro removido com sucesso"],202);

        }catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['errors' => $exception->getMessage()],403);

        }
    }

}
