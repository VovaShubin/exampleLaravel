<?php

namespace App\Core\Exceptions\Traits;

trait ExceptionMessageBagTrait
{
    protected $detail = null;
    protected $id = null;
    protected $links = null;
    protected $type = null;
    protected $statusCode = null;
    protected $source = null;
    protected $pointer = null;
    protected $parameter = null;
    protected $header = null;
    protected $meta = null;

    public function setDetail($detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function setLinks($links): self
    {
        $this->links = $links;

        return $this;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setCode($status): self
    {
        $this->statusCode = $status;

        return $this;
    }

    public function setSource($source): self
    {
        $this->source = $source;

        return $this;
    }

    public function setPointer($pointer): self
    {
        $this->pointer = $pointer;

        return $this;
    }

    public function setParameter($parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function setHeader($header): self
    {
        $this->header = $header;

        return $this;
    }

    public function setMeta($meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function detail()
    {
        return $this->detail;
    }

    public function links()
    {
        return $this->links;
    }



    public function type()
    {
        return $this->type;
    }

    public function code()
    {
        return $this->statusCode;
    }

    public function source()
    {
        return $this->source;
    }

    public function pointer()
    {
        return $this->pointer;
    }

    public function parameter()
    {
        return $this->parameter;
    }

    public function header()
    {
        return $this->header;
    }

    public function meta()
    {
        return $this->meta;
    }
}
