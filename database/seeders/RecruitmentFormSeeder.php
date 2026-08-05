<?php

namespace Database\Seeders;

use App\Models\LookupList;
use App\Models\RecruitmentForm;
use App\Models\RecruitmentFormField;
use Illuminate\Database\Seeder;

class RecruitmentFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Idempotent via updateOrCreate throughout - safe to re-run.
     */
    public function run(): void
    {
        // A) The recruitment form itself
        $form = RecruitmentForm::updateOrCreate(
            ['name' => 'Caregiver Application'],
            [
                'version' => 1,
                'is_active' => true,
            ]
        );

        // B) Lookup lists
        // 'territory' is seeded with NO items - real territory/location names
        // are unknown at this stage and will be filled in by admins via the
        // UI. Each top-level item is a Territory; Locations nest under a
        // Territory as its children (LookupListItem.parent_id).
        LookupList::updateOrCreate(
            ['key' => 'territory'],
            ['label' => 'Territory', 'child_label' => 'Location']
        );

        $sourceList = LookupList::updateOrCreate(
            ['key' => 'source'],
            ['label' => 'Referral Source']
        );

        $sourceItems = [
            'LinkedIn',
            'Employee Referral',
            'Job Board',
            'Walk-in',
            'Other',
        ];

        foreach ($sourceItems as $index => $name) {
            $sourceList->items()->updateOrCreate(
                ['lookup_list_id' => $sourceList->id, 'name' => $name],
                [
                    'order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        // 'status' drives Applicant::validStatuses() - the applicant pipeline
        // stages, in display/progression order.
        $statusList = LookupList::updateOrCreate(
            ['key' => 'status'],
            ['label' => 'Status']
        );

        $statusItems = [
            'New',
            'In Review',
            'Interview',
            'Passed',
            'Orientation',
            'Offer',
            'Hired',
            'Rejected',
        ];

        foreach ($statusItems as $index => $name) {
            $statusList->items()->updateOrCreate(
                ['lookup_list_id' => $statusList->id, 'name' => $name],
                [
                    'order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        // 'role' is seeded with NO items - real role names are unknown at
        // this stage and will be filled in by admins via the UI, same
        // rationale as the empty 'territory' list above.
        LookupList::updateOrCreate(
            ['key' => 'role'],
            ['label' => 'Role']
        );

        // C) Form fields, in display order
        $yesNo = ['Yes', 'No'];

        $fields = [
            ['field_key' => 'dementia_experience', 'label' => 'Dementia Experience', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'hospice_experience', 'label' => 'Hospice Experience', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'bedbound', 'label' => 'Bedbound', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'incontinence_experience', 'label' => 'Incontinence Experience', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'auto_insurance', 'label' => 'Auto Insurance', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'auto_insurance_note', 'label' => 'Auto Insurance Note', 'type' => 'text', 'options' => null, 'is_required' => false, 'help_text' => 'If No — e.g. beneficiary on an existing policy', 'condition_field_key' => 'auto_insurance', 'condition_value' => 'No'],
            ['field_key' => 'drivers_license', 'label' => "Driver's License", 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'okay_transport', 'label' => 'Okay with Transport', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'okay_with_male_female', 'label' => 'Okay with Male/Female Clients', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'okay_with_smokers', 'label' => 'Okay with Smokers', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'okay_with_pets', 'label' => 'Okay with Pets', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'is_smoker', 'label' => 'Are You a Smoker?', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'cpr_fa_cert', 'label' => 'CPR & First Aid Certified?', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'has_allergies', 'label' => 'Any Allergies?', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'allergies_detail', 'label' => 'Allergy Details', 'type' => 'text', 'options' => null, 'is_required' => false, 'help_text' => 'List allergies if yes', 'condition_field_key' => 'has_allergies', 'condition_value' => 'Yes'],
            ['field_key' => 'tb_skin_test_current', 'label' => 'Current TB Skin Test?', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'catheter_experience', 'label' => 'Catheter Client Experience?', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'slide_board_experience', 'label' => 'Slide Board Experience', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'gait_belt_experience', 'label' => 'Gait Belt Experience', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'hoyer_lift_experience', 'label' => 'Hoyer Lift Experience', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'pivot_transfer_experience', 'label' => 'Pivot Transfer Experience', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            // Options resolved at runtime from the 'source' lookup list - not stored here.
            // Deactivated: Source is now a core ATS field captured at intake
            // (Applicant::source_id), not one of the interview questions.
            ['field_key' => 'referral_source', 'label' => 'How Did You Hear About This Opening?', 'type' => 'select', 'options' => null, 'options_source_list_id' => $sourceList->id, 'is_required' => true, 'is_active' => false],
            ['field_key' => 'has_relative_at_company', 'label' => 'Relative Currently at Comfort Keepers?', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'first_application', 'label' => 'Is This Your First Application?', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'couples_care', 'label' => 'Couples Care', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'expected_salary', 'label' => 'Expected Salary', 'type' => 'text', 'options' => null, 'is_required' => true],
            ['field_key' => 'meal_prep', 'label' => 'Meal Prep', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'covid_vaccinated', 'label' => 'COVID Vaccinated', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'certificates', 'label' => 'Certificates Held', 'type' => 'checkbox', 'options' => ['Companion', 'PCA', 'CNA', 'HHA'], 'is_required' => false],
            ['field_key' => 'interested_pca_certification', 'label' => 'Interested in Getting PCA Certified?', 'type' => 'select', 'options' => $yesNo, 'is_required' => true],
            ['field_key' => 'earliest_availability_date', 'label' => 'Earliest Availability Date', 'type' => 'date', 'options' => null, 'is_required' => true],
            ['field_key' => 'latest_availability_date', 'label' => 'Latest Availability Date', 'type' => 'date', 'options' => null, 'is_required' => true],
            ['field_key' => 'other_notes', 'label' => 'Other Notes', 'type' => 'textarea', 'options' => null, 'is_required' => false],
        ];

        foreach ($fields as $index => $field) {
            RecruitmentFormField::updateOrCreate(
                ['form_id' => $form->id, 'field_key' => $field['field_key']],
                [
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'options' => $field['options'],
                    'options_source_list_id' => $field['options_source_list_id'] ?? null,
                    'is_required' => $field['is_required'],
                    'order' => $index + 1,
                    'is_active' => $field['is_active'] ?? true,
                    'file_rules' => null,
                    'help_text' => $field['help_text'] ?? null,
                    'condition_field_key' => $field['condition_field_key'] ?? null,
                    'condition_value' => $field['condition_value'] ?? null,
                ]
            );
        }

        // D) Checklist items - intentionally left empty. The client defines
        // their own post-interview checklist items through the admin UI.
    }
}
