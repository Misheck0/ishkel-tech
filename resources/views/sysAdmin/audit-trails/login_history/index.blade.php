<table class="table-auto w-full">
    <thead>
        <tr>
            <th>User</th>
            <th>Status</th>
            <th>Time</th>
            <th>IP</th>
            <th>Agent</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activities as $a)
        <tr>
            <td>{{ $a->user->name ?? 'Unknown' }}</td>
            <td class="capitalize">{{ $a->status }}</td>
            <td>{{ $a->login_at }}</td>
            <td>{{ $a->ip_address }}</td>
            <td>{{ Str::limit($a->user_agent, 50) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
