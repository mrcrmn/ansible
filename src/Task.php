<?php

namespace Mrcrmn\Ansible;

use InvalidArgumentException;
use Mrcrmn\Ansible\Exceptions\InvalidParameterException;

class Task
{
    /**
     * The Ansible module name to use.
     *
     * @var string
     */
    protected $taskName;

    /**
     * The tasks description.
     *
     * @var string
     */
    protected $description;

    /**
     * The modules parameters.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Create the task.
     *
     * @param string $description
     * @param string $taskName
     * @param array $parameters
     */
    public function __construct(string $description, string $taskName, array $parameters)
    {
        $this->setDescription($description);
        $this->setTaskName($taskName);
        $this->setParameters($parameters);
    }

    /**
     * Sets the description.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Sets the module name.
     *
     * @param string $taskName
     * @return $this
     */
    public function setTaskName(string $taskName): self
    {
        if (preg_match('/[a-z0-9_]/', $taskName) === 0) {
            throw new InvalidArgumentException("'{$taskName}' is not a valid task name. A task name should be lowercase and only include numbers and underscores.");
        }

        $this->taskName = $taskName;

        return $this;
    }

    /**
     * Validates a given parameter.
     *
     * @param string $parameterName The parameter name.
     * @param mixed $parameterValue The value of the parameter.
     * @param array $validation The validation logic.
     * 
     * @throws InvalidParameterException Throws if validation fails.
     * 
     * @return void
     */
    public function validateParameter(string $parameterName, $parameterValue, array $validation)
    {
        if (! array_key_exists($parameterName, $validation)) {
            throw new InvalidParameterException("'{$parameterName}' is not a valid parameter for modules '{$this->taskName}'.");
        }

        $types = is_string($validation[$parameterName]) ? explode('|', $validation[$parameterName]) : false;

        if ($types !== false) {
            $check = false;

            foreach ($types as $type) {
                $typeCheck = call_user_func('is_' . $type, $parameterValue);

                if ($typeCheck) {
                    $check = true;
                    break;
                }
            }

            if (! $check) {
                throw new InvalidParameterException("'{$parameterName}' must be of type " . implode(' or ', $validation[$parameterName]) . ".");
            }
        }

        if (is_array($validation[$parameterName])) {
            $check = in_array($parameterValue, $validation[$parameterName]);

            if (! $check) {
                throw new InvalidParameterException("'{$parameterName}' must be of one of the following values: " . implode(', ', $validation[$parameterName]) . ".");
            }
        }
    }

    /**
     * Sets a module parameter.
     *
     * @param string $parameterName The parameter name.
     * @param string|array $parameterValue The value of the parameter.
     * @return void
     */
    public function setParameter(string $parameterName, $parameterValue)
    {
        if (method_exists($this, 'validParameters')) {
            $this->validateParameter($parameterName, $parameterValue, $this->validParameters());
        }

        $this->parameters[$parameterName] = $parameterValue;
    }

    /**
     * Sets many parameters.
     *
     * @param array $parameters
     * @return void
     */
    public function setParameters(array $parameters): void
    {
        foreach ($parameters as $parameterName => $parameterValue) {
            $this->setParameter($parameterName, $parameterValue);
        }
    }

    /**
     * Gets all parameters.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Converts the task to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->description,
            $this->taskName => $this->getParameters()
        ];
    }
}