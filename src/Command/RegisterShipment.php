<?php

declare(strict_types=1);

namespace App\Command;

use App\Builder\OrderInterface as OrderBuilderInterface;
use App\Service\OrderInterface as OrderServiceInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterShipment extends Command
{
    public const PARAMETER_PROVIDER_KEY = 'providerKey';

    protected static $defaultName = 'app:register-shipment';

    /** @var OrderServiceInterface */
    private $orderService;

    /** @var OrderBuilderInterface */
    private $orderBuilder;

    /**
     * @param OrderServiceInterface $orderService
     * @param OrderBuilderInterface $orderBuilder
     * @param string|null $name
     */
    public function __construct(
        OrderServiceInterface $orderService,
        OrderBuilderInterface $orderBuilder,
        string $name = null
    ) {
        parent::__construct($name);

        $this->orderService = $orderService;
        $this->orderBuilder = $orderBuilder;
    }

    protected function configure(): void
    {
        $this->addArgument(
            'providerKey',
            InputArgument::REQUIRED,
            'Shipping provider key'
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            /*
             * realioj situacijoj orderBuilderio turbut nereiketu,
             * nes orderis jau butu sukurtas is anksciau
             */
            $this->orderService->registerShipping(
                $this->orderBuilder->build(
                    strtolower($input->getArgument(self::PARAMETER_PROVIDER_KEY))
                )
            );
        } catch (Exception $e) {
            //TODO prideti loginima su logeriu
            $output->writeln('There was an error. For more info see logs.');

            return Command::FAILURE;
        }

        $output->writeln('Shipment has been registered successfully!');

        return Command::SUCCESS;
    }
}