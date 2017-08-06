<?php

/**
Copyright (c) 2016 dog-ears

This software is released under the MIT License.
http://dog-ears.net/
*/

namespace App\Traits;
use App\Empleado;
use App\Nivel;
use Auth;
trait RelationManagerTrait {

    /**
     * The relation App.
     *
     * @var relationApps
     */
    protected $relationApps;

    /**
     * Add relation App to list
     *
     * @param  string  $path
     * @return string
     */
    protected function addRelationApp($app, $relation_display_column = 'name'){

		if( !is_object($app) ){
			throw new \Exception( "Argument is not Object!" );
		}

		$appNames = explode( '\\', get_class($app) );
		$appName = end($appNames);

    	$this->relationApps[$appName]['app'] = $app;
    	$this->relationApps[$appName]['relation_display_column'] = $relation_display_column;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function getListFromAllRelationApps()
    {
    	$list = [];

        if( $this->relationApps ){
    		foreach ( $this->relationApps as $relationAppName => $relationAppArray ){
    			$relatedObjList = $relationAppArray['app']::pluck($relationAppArray['relation_display_column'], 'id');
          $e=Empleado::where('user_id', '=', Auth::user()->id)->first();
          if($relationAppName=="Empleado" and Auth::user()->can('IfiltroEmpleadosXPlantel')){
            $relatedObjList = $relationAppArray['app']::where('plantel_id', '=', $e->plantel_id)->pluck($relationAppArray['relation_display_column'], 'id');
            //dd($relatedObjList);
          }
          
          if($relationAppName=="Nivel" and Auth::user()->can('IfiltroNivelXplantel')){
            $relatedObjList = $relationAppArray['app']::where('plantel_id', '=', $e->plantel_id)->pluck($relationAppArray['relation_display_column'], 'id');
            //dd($relatedObjList);
          }
          if($relationAppName=="Grado" and Auth::user()->can('IfiltroGradoXplantel')){
            $relatedObjList = $relationAppArray['app']::where('plantel_id', '=', $e->plantel_id)->pluck($relationAppArray['relation_display_column'], 'id');
            //dd($relatedObjList);
          }
          if($relationAppName=="Curso" and Auth::user()->can('IfiltroCursoXplantel')){
            $relatedObjList = $relationAppArray['app']::where('plantel_id', '=', $e->plantel_id)->pluck($relationAppArray['relation_display_column'], 'id');
            //dd($relatedObjList);
          }
          if($relationAppName=="Subcurso" and Auth::user()->can('IfiltroSubcursoXplantel')){
            $relatedObjList = $relationAppArray['app']::where('plantel_id', '=', $e->plantel_id)->pluck($relationAppArray['relation_display_column'], 'id');
            //dd($relatedObjList);
          }
          if($relationAppName=="Diplomado" and Auth::user()->can('IfiltroDiplomadoXplantel')){
            $relatedObjList = $relationAppArray['app']::where('plantel_id', '=', $e->plantel_id)->pluck($relationAppArray['relation_display_column'], 'id');
            //dd($relatedObjList);
          }
          if($relationAppName=="Subdiplomado" and Auth::user()->can('IfiltroSubdiplomadoXplantel')){
            $relatedObjList = $relationAppArray['app']::where('plantel_id', '=', $e->plantel_id)->pluck($relationAppArray['relation_display_column'], 'id');
            //dd($relatedObjList);
          }
          if($relationAppName=="Otro" and Auth::user()->can('IfiltroOtroXplantel')){
            $relatedObjList = $relationAppArray['app']::where('plantel_id', '=', $e->plantel_id)->pluck($relationAppArray['relation_display_column'], 'id');
            //dd($relatedObjList);
          }
          if($relationAppName=="Subotro" and Auth::user()->can('IfiltroSubotroXplantel')){
            $relatedObjList = $relationAppArray['app']::where('plantel_id', '=', $e->plantel_id)->pluck($relationAppArray['relation_display_column'], 'id');
            //dd($relatedObjList);
          }
          //$relatedObjList = $relationAppArray['app']::pluck($relationAppArray['relation_display_column'], 'id');
    			$list[$relationAppName] = $relatedObjList;
    		}
        }
		return $list;
    }
}