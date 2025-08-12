<?php

namespace Lendable\Interview\FeeCalculator\Application\Command;

use Lendable\Interview\FeeCalculator\Domain\Model\LoanApplication;
use Lendable\Interview\FeeCalculator\Domain\Service\FeeCalculatorService;
use Lendable\Interview\FeeCalculator\Domain\Service\FeeInterpolator;
use Lendable\Interview\FeeCalculator\Domain\Service\RoundingCalculator;
use Lendable\Interview\FeeCalculator\Infrastructure\Data\FeeBreakpointDataProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CalculateFeeCommand extends Command
{
    protected static $defaultName = 'app:calculate-fee';

    protected function configure(): void
    {
        $this
            ->setDescription('Calculates the fee for a loan application')
            ->addArgument('amount', InputArgument::REQUIRED, 'Loan amount (e.g. 20,000.00)')
            ->addArgument('term', InputArgument::REQUIRED, 'Loan term in months (12 or 24)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $amount = $this->parseAmount($input->getArgument('amount'));
            $term = (int)$input->getArgument('term');

            $application = new LoanApplication($amount, $term);
            $dataProvider = new FeeBreakpointDataProvider();
            $calculator = new FeeCalculatorService(new FeeInterpolator(), new RoundingCalculator());

            $fee = $calculator->calculate($application, $dataProvider->getForTerm($term));

            $output->writeln(number_format($fee, 2));
            return Command::SUCCESS;
        } catch (\InvalidArgumentException $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }

    private function parseAmount(string $amountString): float
    {
        $amount = str_replace(',', '', $amountString);
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException('Amount must be a numeric value');
        }

        return (float)$amount;
    }
}