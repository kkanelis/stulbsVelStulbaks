<div class="space-y-4">
    <h3 class="text-lg font-semibold">Pēdējie iesniegumi</h3>
    <ul class="space-y-2">
        @foreach($this->getRecentSubmissions() as $f)
            <li class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium">{{ optional($f->user)->name }} — <span class="text-xs text-gray-500">{{ optional($f->assignment)->title }}</span></div>
                    <div class="text-xs text-gray-400">{{ $f->created_at->diffForHumans() }}</div>
                </div>
                @if($f->path)
                    <a href="{{ route('file.download', $f->id) }}" class="text-sm text-blue-600">Lejupielādēt</a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
