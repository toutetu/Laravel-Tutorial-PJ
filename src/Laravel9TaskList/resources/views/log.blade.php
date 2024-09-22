@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">ログ管理画面</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">日時</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ユーザー名</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">画面</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">アクション</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->created_at->format('Y/m/d H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->causer ? $activity->causer->name : 'システム' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->properties['screen'] ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $activities->links() }}
    </div>
</div>
@endsection