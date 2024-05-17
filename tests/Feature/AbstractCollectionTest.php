<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\DataObjects\AbstractCollection;
use Mockery;
use OutOfBoundsException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AbstractCollectionTest extends TestCase
{
    public function test_count_method(): void
    {
        $collection = new MockCollection(1, 2, 3);
        $this->assertEquals(3, $collection->count());
    }

    public function test_update_method(): void
    {
        $items = [1, 2, 3];
        $mockedCollection = Mockery::mock(MockCollection::class.'[count]', $items);
        $mockedCollection->shouldReceive('count')->andReturn(count($items));
        $index = 2;
        $newValue = 5;
        $mockedCollection->update($index, $newValue);
        $this->assertEquals($newValue, $mockedCollection->getIterator()->offsetGet($index));
    }

    #[DataProvider('provideIndex')]
    public function test_throws_exception_when_update_value_out_of_bound(int $index): void
    {

        $items = [1, 2, 3];
        $mockedCollection = Mockery::mock(MockCollection::class.'[count]', $items);
        $mockedCollection->shouldReceive('count')->andReturn(count($items));
        $newValue = 5;
        $this->expectException(OutOfBoundsException::class);
        $mockedCollection->update($index, $newValue);
    }

    public function test_remove_method(): void
    {
        $items = [1, 2, 3];
        $mockedCollection = Mockery::mock(MockCollection::class.'[count]', $items);
        $mockedCollection->shouldReceive('count')->andReturn(count($items));
        $index = 2;
        $mockedCollection->remove($index);
        $this->assertEquals([1, 2], iterator_to_array($mockedCollection->getIterator()));
    }

    #[DataProvider('provideIndex')]
    public function test_throws_exception_when_remove_value_out_of_bound(int $index): void
    {
        $items = [1, 2, 3];
        $mockedCollection = Mockery::mock(MockCollection::class.'[count]', $items);
        $mockedCollection->shouldReceive('count')->andReturn(count($items));
        $this->expectException(OutOfBoundsException::class);
        $mockedCollection->remove($index);
    }

    public function test_get_method(): void
    {
        $items = [1, 2, 3];
        $mockedCollection = Mockery::mock(MockCollection::class.'[count]', $items);
        $mockedCollection->shouldReceive('count')->andReturn(count($items));
        $index = 2;
        $this->assertEquals($items[$index], $mockedCollection->get($index));
    }

    #[DataProvider('provideIndex')]
    public function test_throws_exception_when_get_value_out_of_bound(int $index): void
    {

        $items = [1, 2, 3];
        $mockedCollection = Mockery::mock(MockCollection::class.'[count]', $items);
        $mockedCollection->shouldReceive('count')->andReturn(count($items));
        $this->expectException(OutOfBoundsException::class);
        $mockedCollection->get($index);
    }

    public function test_add_method(): void
    {
        $collection = new MockCollection(1, 2, 3);
        $collection->add(4);
        $this->assertEquals([1, 2, 3, 4], iterator_to_array($collection->getIterator()));
    }

    public static function provideIndex(): array
    {
        return ['index is negative number' => [-1], 'index is larger than the array' => [100]];
    }
}

class MockCollection extends AbstractCollection
{
}
