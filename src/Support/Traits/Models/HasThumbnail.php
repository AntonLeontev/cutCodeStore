<?php

namespace Src\Support\Traits\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait HasThumbnail
{
	abstract protected function thumbnailDir(): string;

	public function makeThumbnail(string $size, string $method = 'resize'): string
	{
		return route('thumbnail', [
			'dir' => $this->thumbnailDir(),
			'size' => $size,
			'method' => $method,
			'file' => File::basename($this->{$this->thumbnailColumn()})
		]);
	}

	protected function thumbnailColumn()
	{
		return 'thumbnail';
	}
}
