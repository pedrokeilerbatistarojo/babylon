<?php

namespace App\Shared\Contracts\Report;

use App\Business\Domain\Models\Business;
use App\Reports\Domain\Models\ReportAgent;
use App\Reports\Domain\Models\ReportAgentSummary;
use App\Reports\Domain\Models\ReportBase;
use App\Reports\Domain\Models\ReportClub;

interface ReportServiceInterface
{
    public function getCurrentClubReport(): ReportClub;

    public function updateCurrentClubReport(): ReportClub;

    public function getCurrentAccountingReport(): ReportClub;

    public function updateCurrentAccountingReport(): ReportClub;

    public function getCurrentAgentReport(Business $business): ReportAgent;

    public function updateCurrentAgentReport(Business $business): ReportAgent;

    public function getCurrentAgentSummaryReport(int $agent_id): ReportAgentSummary;

    public function updateCurrentAgentSummaryReport(int $agent_id): ReportAgentSummary;

    public function calcLifeCommission(ReportBase $report): bool;

    public function makePayment(ReportBase $report, array $input): bool;
}
