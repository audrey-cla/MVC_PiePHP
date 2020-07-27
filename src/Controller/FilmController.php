<?php

namespace src\Controller;

class FilmController extends \Core\Controller
{
    public function indexAction()
    {
        $params = $this->request->getParams();
        if (!isset($params['id'])) {
            $user = new \src\Model\FilmModel($params);
            $array = $user->rendu();
        }
        $this->render('Film/index', $array);
    }

    public function showAction($id = "")
    {
        $params = $this->request->getParams();
        $user = new \src\Model\FilmModel($params);
        $array = $user->showmovie($id);
        $array = json_decode(json_encode($array), FALSE);
        if ($id == '' || empty($array)) {
            header('Location: http://localhost/MVC_PiePHP/film');
            exit();
        }

        $this->render('Film/show', $array);
    }

    public function deleteAction($id = "")
    {
        $this->render('Film/delete', [$id]);
        $params = $this->request->getParams();
        $user = new \src\Model\FilmModel($params);
        if (!empty($params)) {
            $user->delete($id);
        }
        else {
            echo "nope";
        }
        $array = $user->find($params = ["WHERE" => "id_film = $id", "nojoin"]);
        if ($id == '' || empty($array)) {
            header('Location: http://localhost/MVC_PiePHP/film');
            exit();
        }
    }

    public function updateAction($id = "")
    {
        $params = $this->request->getParams();
        $user = new \src\Model\FilmModel($params);
        if (!empty($params)) {
            $user->update($id, $params);
        }

        $array = $user->find($params = ["WHERE" => "id_film = $id", "nojoin"]);
        $this->render('Film/update', $array);
        if ($id == '' || empty($array)) {
            header('Location: http://localhost/MVC_PiePHP/film');
            exit();
        }
    }
}
