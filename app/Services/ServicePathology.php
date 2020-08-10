<?php


namespace App\Services;


use App\Models\Pathology;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ServicePathology
{
    private Pathology $pathology;

    public function __construct(Pathology $pathology)
    {
        $this->pathology = $pathology;
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $this->pathology->create($request->all());

            DB::commit();
            return response()->json(["success" => "Registro criado com sucesso"], Response::HTTP_CREATED);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['errors' => $exception->getMessage()], Response::HTTP_FORBIDDEN);
        }
    }

    public function update($request, $pathology)
    {
        try {

            DB::beginTransaction();

            $this->pathology->find($pathology)->update($request->all());

            DB::commit();
            return response()->json(["success" => "Registro atualizado com sucesso"], Response::HTTP_ACCEPTED);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['errors' => $exception->getMessage()], Response::HTTP_FORBIDDEN);
        }
    }

    public function destroy($pathololy)
    {
        try {

            DB::beginTransaction();

            $result = $this->pathology->findOrFail($pathololy);

            $result->users_x_pathology()->delete();
            $result->delete();

            DB::commit();
            return response()->json(["success" => "Registro removido com sucesso"], Response::HTTP_NO_CONTENT);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['errors' => $exception->getMessage()], Response::HTTP_FORBIDDEN);
        }
    }
}
