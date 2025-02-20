<?php 
namespace App\Gestions;
use App\Models\Competence;
use DB;
class GestionCompetence
{
	/**
	 * Retourne toutes les competences
	 * @access public
	 * @return Response 
	 */
	public function all($request){

		try {

			$competences = Competence::whereIn('id_profil', function ($query) use ($request){
	            $query->from('profil')->whereIdUtilisateur($request->user()->id_utilisateur)
	            ->select('id_profil')->get();
	        })->with('profil')->get();

	        return response()->json([
	            'status' => true,
	            'competences' => $competences
	        ]);
            
        } catch(\Exception $e) {

			return response()->json([
				'status'  => false,
				'message' => $e->getMessage() ,
			]);
        }

	}

	/**
	 * Retourne une competence
	 * @access public
	 * @param $id
	 * @return Response
	 * 
	 */
	public function find($request, $id){

		try {

			$competences = Competence::whereIn('id_profil', function ($query) use ($request){
	            $query->from('profil')->whereIdUtilisateur($request->user()->id_utilisateur)
	            ->select('id_profil')->get();
	        })->whereIdCompetence($id)->with('profil');

	        return response()->json([
	            'status' => $competences->exists(),
	            'competence' => $competences->exists() ? $competences->first():null
	        ]);
            
        } catch(\Exception $e) {
			return response()->json([
				'status'  => false,
				'message' => $e->getMessage() ,
			]);
        }
	}

	/**
	 * Enregistre une competence
	 * @access public
	 * @param $CompetenceRequest
	 * @return Response
	 */
    public function store($data)
	{
		try {

            $competence = Competence::create([
				'id_profil' => $data->profil,
				'nom' => $data->nom,
				'niveau' => $data->niveau
			]);

            return response()->json([
				'status' => true,
				'id' => $competence->id_competence,
				'message' => trans("Competence créée avec succès")
			]);
            
        } catch(\Exception $e) {

			return response()->json([
				'status'  => false,
				'message' => $e->getMessage() ,
			]);
        }
	}

	/**
	 * Mettre à jours une competence
	 * @access public
	 * @param $CompetenceRequest, $id
	 * @return Response
	 */

	public function update($data, $id)
	{
		try {

			$competence = Competence::whereIn('id_profil', function ($query) use ($data){
	            $query->from('profil')->whereIdUtilisateur($data->user()->id_utilisateur)
	            ->select('id_profil')->get();
	        })->whereIdCompetence($id);

	        if ($competence->exists()) {

	        	$competence->first()->update([
					'nom' => $data->nom,
					'niveau' => $data->niveau
				]);
	        }

	        $status = $competence->exists();

			return response()->json([
				'status' => $status,
				'id' => $status ? $competence->first()->id_competence:null,
				'message' => $status ? "Competence modifié avec succès":"Competence invalide"
			]);
            
        } catch(\Exception $e) {

			return response()->json([
				'status'  => false,
				'message' => $e->getMessage() ,
			]);
        }
	}

	/**
	 * Supprime une competence
	 * @access public
	 * @param $id
	 * @return Response
	 * 
	 */
	public function delete($data, $id)
	{
		try {

			$competence = Competence::whereIn('id_profil', function ($query) use ($data){
				$query->from('profil')->whereIdUtilisateur($data->user()->id_utilisateur)
				->select('id_profil')->get();
			})->whereIdCompetence($id);

			$status = $competence->exists();

			$competence->delete();

            return response()->json([
				'status' => $status,
				'message' => $status ? "Competence supprimée avec succès":"competence invalide"
			]);
            
        } catch(\Exception $e) {

			return response()->json([
				'status'  => false,
				'message' => $e->getMessage() ,
			]);
        }
	}
}
