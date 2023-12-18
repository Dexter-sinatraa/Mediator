<?php
// Інтерфейс посередника
interface Mediator {
    public function notify(Component $sender, $event);
}

// Базовий клас компонента
abstract class Component {
    protected $mediator;

    public function __construct(Mediator $mediator) {
        $this->mediator = $mediator;
    }

    abstract public function send($event);
    abstract public function receive($event);
}

// Конкретні компоненти
class ConcreteComponentA extends Component {
    public function send($event) {
        echo "Component A sends: $event<br>";
        $this->mediator->notify($this, $event);
    }

    public function receive($event) {
        echo "Component A receives: $event<br>";
    }
}

class ConcreteComponentB extends Component {
    public function send($event) {
        echo "Component B sends: $event<br>";
        $this->mediator->notify($this, $event);
    }

    public function receive($event) {
        echo "Component B receives: $event<br>";
    }
}

// Конкретний посередник
class ConcreteMediator implements Mediator {
    private $componentA;
    private $componentB;

    public function setComponentA(ConcreteComponentA $componentA) {
        $this->componentA = $componentA;
    }

    public function setComponentB(ConcreteComponentB $componentB) {
        $this->componentB = $componentB;
    }

    public function notify(Component $sender, $event) {
        if ($sender === $this->componentA) {
            $this->componentB->receive($event);
        } elseif ($sender === $this->componentB) {
            $this->componentA->receive($event);
        }
    }
}

// Використання паттерна Посередник
$mediator = new ConcreteMediator();

$componentA = new ConcreteComponentA($mediator);
$componentB = new ConcreteComponentB($mediator);

$mediator->setComponentA($componentA);
$mediator->setComponentB($componentB);

$componentA->send("Hello from Component A!"); // Component A sends: Hello from Component A!; Component B receives: Hello from Component A!
$componentB->send("Hi from Component B!");    // Component B sends: Hi from Component B!; Component A receives: Hi from Component B!
