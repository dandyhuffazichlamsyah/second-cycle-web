<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'brand', 'type', 'cc', 'price', 'image', 'short_description', 'description',
        'year_manufacture', 'year_assembly', 'color',
        'stnk_status', 'bpkb_status', 'tax_status', 'tax_expiry', 'plate_number_status',
        'body_condition', 'frame_condition', 'legs_condition', 'seat_condition', 'electrical_condition',
        'engine_sound', 'oil_leak', 'exhaust_smoke', 'engine_pull', 'fuel_consumption', 'radiator_condition', 'battery_condition',
        'odometer', 'usage_type', 'usage_location', 'location',
        'routine_service', 'service_book', 'service_notes', 'recent_part_replacement',
        'exhaust_type', 'modifications', 'modifications_legal',
        'accident_history', 'flood_history', 'frame_damage', 'repainted', 'engine_overhaul',
        'spare_key', 'toolkit', 'manual_book', 'bonus_helmet',
        'status', 'grade'
    ];

    protected $casts = [
        'tax_expiry' => 'date',
        'routine_service' => 'boolean',
        'service_book' => 'boolean',
        'modifications_legal' => 'boolean',
        'accident_history' => 'boolean',
        'flood_history' => 'boolean',
        'frame_damage' => 'boolean',
        'repainted' => 'boolean',
        'engine_overhaul' => 'boolean',
        'spare_key' => 'boolean',
        'toolkit' => 'boolean',
        'manual_book' => 'boolean',
        'bonus_helmet' => 'boolean',
    ];

    public function calculateGrade()
    {
        $score = 100;

        // Critical Issues (Instant Grade D)
        if ($this->frame_condition === 'Bengkok' || $this->accident_history || $this->frame_damage) {
            return 'D';
        }

        // Major Deductions
        if ($this->tax_status === 'Mati') $score -= 15;
        if ($this->engine_sound === 'Menggelitik') $score -= 15;
        if ($this->oil_leak === 'Bocor') $score -= 15;
        if ($this->flood_history) $score -= 20;
        if ($this->engine_overhaul) $score -= 10;

        // Moderate Deductions
        if ($this->body_condition === 'Lecet Parah') $score -= 10;
        if ($this->frame_condition === 'Karat') $score -= 10;
        if ($this->legs_condition === 'Oblak') $score -= 10;
        if ($this->oil_leak === 'Rembes') $score -= 5;
        if ($this->body_condition === 'Repaint' || $this->repainted) $score -= 5;
        if ($this->electrical_condition === 'Perlu Perbaikan') $score -= 5;

        // Minor Deductions
        if ($this->body_condition === 'Lecet Pemakaian') $score -= 2;
        if ($this->stnk_status === 'Hilang' || $this->bpkb_status === 'Hilang') $score -= 10; // Serious paper issue

        // Determine Grade
        if ($score >= 90) return 'A';
        if ($score >= 75) return 'B';
        if ($score >= 60) return 'C';
        return 'D';
    }

    public function getGradeLabelAttribute()
    {
        $labels = [
            'A' => 'Sangat Baik',
            'B' => 'Baik',
            'C' => 'Cukup',
            'D' => 'Kurang'
        ];
        return $labels[$this->grade] ?? 'Belum Dinilai';
    }

    public function getGradeColorAttribute()
    {
        $colors = [
            'A' => 'success',
            'B' => 'primary',
            'C' => 'warning',
            'D' => 'danger'
        ];
        return $colors[$this->grade] ?? 'secondary';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
