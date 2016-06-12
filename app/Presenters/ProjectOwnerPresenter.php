<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectOwnerTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectOwnerPresenter
 *
 * @package namespace CodeProject\Presenters;
 */
class ProjectOwnerPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectOwnerTransformer();
    }
}
