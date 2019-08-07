<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bug;
use App\Repositories\EventRepository;
use App\Repositories\ProviderCategoryRepository;
use App\Repositories\ProviderRepository;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    private $repository;
    private $categoryRepository;
    private $eventRepository;

    public function __construct(ProviderRepository $repository, ProviderCategoryRepository $categoryRepository,
                                EventRepository $eventRepository)
    {

        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->eventRepository = $eventRepository;
    }

    /*
     * Listagem de Fornecedores
     * filtrado por evento ou retorna todos
     */
    public function index($event_id = null)
    {
        if($event_id)
        {
            $event = $this->eventRepository->findByField('id', $event_id)->first();

            if($event)
            {
                $speakers = $this->repository->findByField('event_id', $event_id);

                if(count($speakers) > 0)
                {
                    return json_encode(['status' => true, 'count' => count($speakers), 'speakers' => $speakers]);
                }
                else{

                    return json_encode(['status' => false, 'count' => 0]);
                }
            }

            $bug = new Bug();

            $bug->description = 'Não existe o evento com id: ' . $event_id;
            $bug->platform = 'App';
            $bug->location = 'index() Api\ProviderController.php';
            $bug->model = 'Provider';
            $bug->status = 'Pendente';
            $bug->church_id = 0;

            return json_encode(['status' => false, 'msg' => 'Não existe o evento informado']);
        }
        else{

            $speakers = $this->repository->all();

            if(count($speakers) > 0)
            {
                foreach ($speakers as $item)
                {
                    if($item->event_id)
                    {
                        $event = $this->eventRepository->findByField('id', $item->event_id)->first();
                        $item->event_name = $event ? $event->name : '';
                    }
                }
                return json_encode(['status' => true, 'count' => count($speakers), 'speakers' => $speakers]);
            }
            else{

                return json_encode(['status' => false, 'count' => 0]);
            }
        }
    }

    /*
     * Mostra os detalhes de um Fornecedores.
     */
    public function show($id)
    {
        $speaker = $this->repository->findByField('id', $id)->first();

        if($speaker)
        {
            return json_encode(['status' => true, 'speaker' => $speaker]);
        }

        return json_encode(['status' => false, 'msg' => 'Este Palestrante não existe']);
    }


    /*
     * Cadastra um novo Fornecedores
     * (Pode-se atrelar um Fornecedores ao evento)
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if($data['name'] == "" || !isset($data['name']))
        {
            return json_encode(['status' => false, 'msg' => 'Campo nome não pode estar em branco']);
        }

        if($data['description'] == "" || !isset($data['description']))
        {
            return json_encode(['status' => false, 'msg' => 'Campo descrição não pode estar em branco']);
        }

        try{

            if($data['event_id'])
            {
                $event = $this->eventRepository->findByField('id', $data['event_id'])->first();

                if($event)
                {
                    if(isset($data['category_id']) && $data['category_id'] > 0)
                    {
                        $category = $this->categoryRepository->findByField('id', $data['category_id'])->first();

                        if(!$category)
                        {
                            return json_encode(['status' => false, 'msg' => 'Esta Categoria não existe']);
                        }

                        $this->repository->create($data);

                        \DB::commit();

                        return json_encode(['status' => true]);
                    }
                    elseif(!isset($data['category_id']))
                    {
                        $this->repository->create($data);

                        \DB::commit();

                        return json_encode(['status' => true]);
                    }


                }
                else{

                    \DB::rollBack();

                    $bug = new Bug();

                    $bug->description = 'O evento com id: ' . $data['event_id'] . ' não existe';
                    $bug->platform = 'App';
                    $bug->model = 'Provider';
                    $bug->location = 'store() Api\ProviderController.php';
                    $bug->status = 'Pendente';
                    $bug->church_id = 0;

                    $bug->save();

                    return json_encode(['status' => false, 'Este Evento não existe']);
                }

            }
            else{

                $this->repository->create($data);

                \DB::commit();

                return json_encode(['status' => true]);
            }

        }catch (\Exception $e)
        {
            \DB::rollBack();

            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'App';
            $bug->model = 'Provider';
            $bug->location = 'store() Api\ProviderController.php';
            $bug->status = 'Pendente';
            $bug->church_id = 0;

            $bug->save();

            return json_encode(['status' => false, $e->getMessage()]);
        }

    }

    /*
     * Usado para atualizar as info de um Fornecedores
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $speaker = $this->repository->findByField('id', $id)->first();

        if($speaker)
        {
            if($data['name'] == "" || !isset($data['name']))
            {
                return json_encode(['status' => false, 'msg' => 'Campo nome não pode estar em branco']);
            }

            if($data['description'] == "" || !isset($data['description']))
            {
                return json_encode(['status' => false, 'msg' => 'Campo descrição não pode estar em branco']);
            }

            try{

                if($data['event_id'])
                {
                    $event = $this->eventRepository->findByField('id', $data['event_id'])->first();

                    if($event)
                    {
                        if(isset($data['category_id']) && $data['category_id'] > 0)
                        {
                            $category = $this->categoryRepository->findByField('id', $data['category_id'])->first();

                            if(!$category)
                            {
                                return json_encode(['status' => false, 'msg' => 'Esta Categoria não existe']);
                            }

                            $this->repository->update($data, $id);

                            \DB::commit();

                            return json_encode(['status' => true]);
                        }
                        elseif(!isset($data['category_id']))
                        {
                            $this->repository->update($data, $id);ß

                        \DB::commit();

                            return json_encode(['status' => true]);
                        }
                    }
                    else{

                        \DB::rollBack();

                        $bug = new Bug();

                        $bug->description = 'O evento com id: ' . $data['event_id'] . ' não existe';
                        $bug->platform = 'App';
                        $bug->model = 'Provider';
                        $bug->location = 'store() Api\ProviderController.php';
                        $bug->status = 'Pendente';
                        $bug->church_id = 0;

                        $bug->save();

                        return json_encode(['status' => false, 'Este Evento não existe']);
                    }

                }
                else{

                    $this->repository->update($data, $id);

                    \DB::commit();

                    return json_encode(['status' => true]);
                }

            }catch (\Exception $e)
            {
                \DB::rollBack();

                $bug = new Bug();

                $bug->description = $e->getMessage();
                $bug->platform = 'App';
                $bug->model = 'Provider';
                $bug->location = 'store() Api\ProviderController.php';
                $bug->status = 'Pendente';
                $bug->church_id = 0;

                $bug->save();

                return json_encode(['status' => false, $e->getMessage()]);
            }

        }else{

            $bug = new Bug();

            $bug->description = 'Palestrante com id: ' . $id . ' não foi encontrado';
            $bug->platform = 'App';
            $bug->model = 'Provider';
            $bug->location = 'update() Api\ProviderController.php';
            $bug->status = 'Pendente';
            $bug->church_id = 0;

            $bug->save();

            return json_encode(['status' => false, 'msg' => 'Palestrante não encontrado']);
        }


    }

    /*
     * Usado para excluir um Fornecedores
     */
    public function delete($id)
    {
        try{

            $this->repository->delete($id);

            \DB::commit();

            return json_encode(['status' => true]);

        }catch (\Exception $e)
        {
            \DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

    /*
     * Usado para retornar Fornecedores por categoria
     */
    public function listByCategory($category_id)
    {
        $speakers = $this->repository->findByField('category_id', $category_id);

        if(count($speakers) > 0)
        {
            return json_encode(['status' => true, 'count' => count($speakers), 'speakers' => $speakers]);
        }

        return json_encode(['status' => true, 'count' => 0]);
    }

    /*
     * Lista de Categorias por evento ou geral
     */

    public function index_cat($event_id = null)
    {
        if($event_id)
        {
            $event = $this->eventRepository->findByField('id', $event_id)->first();

            if($event)
            {
                $categories = $this->categoryRepository->findByField('event_id', $event_id);

                if(count($categories) > 0)
                {
                    return json_encode(['status' => true, 'count' => count($categories), 'categories' => $categories]);
                }

                return json_encode(['status' => true, 'count' => 0]);
            }
            else{

                $bug = new Bug();

                $bug->description = 'O evento(id: '.$event_id.') que esta categoria pertence não existe';
                $bug->platform = 'App';
                $bug->location = 'index_cat() Api\ProviderController.php';
                $bug->model = 'Providers';
                $bug->status = 'Pendente';
                $bug->church_id = 0;

                $bug->save();

                return json_encode(['status' => false, 'msg' => 'O evento que esta categoria pertence não existe']);
            }
        }
        else{

            $categories = $this->categoryRepository->all();

            if(count($categories) > 0)
            {
                return json_encode(['status' => true, 'count' => count($categories), 'categories' => $categories]);
            }

            return json_encode(['status' => true, 'count' => 0]);
        }

    }

    /*
     * Cadastra uma nova categoria de Fornecedores
     * sendo por evento ou geral
     */
    public function store_cat(Request $request)
    {
        $data = $request->all();

        if(isset($data['event_id']) && $data['event_id'] != "")
        {
            $event = $this->eventRepository->findByField('id', $data['event_id'])->first();

            if($event)
            {
                try{

                    $this->categoryRepository->create($data);

                    \DB::commit();

                    return json_encode(['status' => true]);

                }catch (\Exception $e)
                {
                    \DB::rollBack();

                    $bug = new Bug();

                    $bug->description = $e->getMessage();
                    $bug->platform = 'App';
                    $bug->location = 'store_cat() Api\ProviderController.php';
                    $bug->model = 'Providers';
                    $bug->status = 'Pendente';
                    $bug->church_id = 0;

                    $bug->save();

                    return json_encode(['status' => false, 'msg' => $e->getMessage()]);
                }
            }
            else{

                $bug = new Bug();

                $bug->description = 'O evento(id: '.$data['event_id'].') que esta categoria pertence não existe';
                $bug->platform = 'App';
                $bug->location = 'store_cat() Api\ProviderController.php';
                $bug->model = 'Providers';
                $bug->status = 'Pendente';
                $bug->church_id = 0;

                $bug->save();

                return json_encode(['status' => false, 'msg' => 'O evento que esta categoria pertence não existe']);
            }

        }
        else{

            try{

                $this->categoryRepository->create($data);

                \DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e)
            {
                \DB::rollBack();

                $bug = new Bug();

                $bug->description = $e->getMessage();
                $bug->platform = 'App';
                $bug->location = 'store_cat() Api\ProviderController.php';
                $bug->model = 'Providers';
                $bug->status = 'Pendente';
                $bug->church_id = 0;

                $bug->save();

                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }
        }
    }


    /*
     * Alteração de uma categoria de Fornecedores
     */
    public function update_cat(Request $request, $id)
    {
        $data = $request->all();

        $cat = $this->categoryRepository->findByField('id', $id)->first();

        if($cat)
        {

            if(isset($data['event_id']) && $data['event_id'] != "")
            {
                $event = $this->eventRepository->findByField('id', $data['event_id'])->first();

                if($event)
                {
                    try{

                        $this->categoryRepository->update($data, $id);

                        \DB::commit();

                        return json_encode(['status' => true]);

                    }catch (\Exception $e)
                    {
                        \DB::rollBack();

                        $bug = new Bug();

                        $bug->description = $e->getMessage();
                        $bug->platform = 'App';
                        $bug->location = 'store_cat() Api\ProviderController.php';
                        $bug->model = 'Providers';
                        $bug->status = 'Pendente';
                        $bug->church_id = 0;

                        $bug->save();

                        return json_encode(['status' => false, 'msg' => $e->getMessage()]);
                    }
                }
                else{

                    $bug = new Bug();

                    $bug->description = 'O evento(id: '.$data['event_id'].') que esta categoria pertence não existe';
                    $bug->platform = 'App';
                    $bug->location = 'update_cat() Api\ProviderController.php';
                    $bug->model = 'Providers';
                    $bug->status = 'Pendente';
                    $bug->church_id = 0;

                    $bug->save();

                    return json_encode(['status' => false, 'msg' => 'O evento que esta categoria pertence não existe']);
                }

            }
            else{

                try{

                    $this->categoryRepository->update($data, $id);

                    \DB::commit();

                    return json_encode(['status' => true]);

                }catch (\Exception $e)
                {
                    \DB::rollBack();

                    $bug = new Bug();

                    $bug->description = $e->getMessage();
                    $bug->platform = 'App';
                    $bug->location = 'update_cat() Api\ProviderController.php';
                    $bug->model = 'Providers';
                    $bug->status = 'Pendente';
                    $bug->church_id = 0;

                    $bug->save();

                    return json_encode(['status' => false, 'msg' => $e->getMessage()]);
                }
            }
        }
        else{

            $bug = new Bug();

            $bug->description = 'Esta categoria com id: '.$id. ' não existe';
            $bug->platform = 'App';
            $bug->location = 'update_cat() Api\ProviderController.php';
            $bug->model = 'Providers';
            $bug->status = 'Pendente';
            $bug->church_id = 0;

            $bug->save();

            return json_encode(['status' => false, 'msg' => 'Esta categoria não existe']);

        }

    }

    public function delete_cat($id)
    {
        $cat = $this->categoryRepository->findByField('id', $id)->first();

        if($cat)
        {

            $speakers = \DB::table('speakers')
                ->where([
                    'category_id' => $id
                ])
                ->update(['category_id' => '']);

            if($speakers)
            {
                try{

                    $this->categoryRepository->delete($id);

                    \DB::commit();

                    return json_encode(['status' => true]);

                }catch (\Exception $e)
                {
                    \DB::rollBack();

                    $bug = new Bug();

                    $bug->description = $e->getMessage();
                    $bug->platform = 'App';
                    $bug->location = 'delete_cat() Api\ProviderController.php';
                    $bug->model = 'Providers';
                    $bug->status = 'Pendente';
                    $bug->church_id = 0;

                    $bug->save();

                    return json_encode(['status' => false, 'msg' => $e->getMessage()]);
                }
            }
        }
    }
}
