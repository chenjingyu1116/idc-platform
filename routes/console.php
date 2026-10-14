<?php
use Illuminate\Support\Facades\Schedule;
Schedule::command('services:check-expiring')->dailyAt('09:00');
