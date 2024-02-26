<x-mail::message>
    # Introduction

    Congratulations, {{ $name }}!
    You have been shortlisted for the job: {{ $jobTitle }}. Please login to your account to view the details.

    Beast regards,<br>
    {{ config('app.name') }}
</x-mail::message>
