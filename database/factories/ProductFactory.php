<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->ean13(),
            'category_id' => $this->faker->numberBetween(1, 10), // Assuming you have 10 categories
            'name' => $this->faker->randomElement([
                'កុំព្យូទ័រ - Computer', 'ទូរស័ព្ទដៃ - Smartphone', 'ថេប្លេត - Tablet', 'កាស - Headphones',
                'នាឡិកាឆ្លាតវៃ - Smartwatch', 'កាមេរ៉ា - Camera', 'ម៉ាស៊ីនព្រីន - Printer', 'ម៉ូនីទ័រ - Monitor',
                'ក្តារចុច - Keyboard', 'កណ្តុរ - Mouse', 'ឆាក្សែរអាគុយ - Charger', 'Power Bank - Power Bank',
                'ខ្សែយូអេសប៊ី - USB Cable', 'ខ្សែអេចឌីអិមអាយ - HDMI Cable', 'Speaker Bluetooth - Bluetooth Speaker',
                'កាសឥតខ្សែ - Wireless Earbuds', 'ទូរទស្សន៍ឆ្លាតវៃ - Smart TV', 'ម៉ាស៊ីនលេងហ្គេម - Game Console',
                'VR Headset - VR Headset', 'Drone - Drone', 'កាមេរ៉ាដំណើរការ - Action Camera', 'ឧបករណ៍តាមដានសុខភាព - Fitness Tracker',
                'Smart Home Hub - Smart Home Hub', 'ភីហ្សា - Pizza', 'អាវយឺត - T-Shirt', 'ឪឡឹក - Watermelon',
                'កៅអី - Chair', 'សៀវភៅ - Book', 'ស្បែកជើង - Shoes', 'កាបូបស្ពាយ - Backpack', 'នាឡិកា - Watch',
                'តុ - Desk', 'ចង្កៀង - Lamp', 'សាឡុង - Sofa', 'គ្រែ - Bed', 'ភួយ - Blanket',
                'ខ្នើយ - Pillow', 'កែវ - Cup', 'ចាន - Plate', 'សម - Fork', 'កាំបិត - Knife',
                'ស្លាបព្រា - Spoon', 'ដប - Bottle', 'កាបូប - Bag', 'មួក - Hat', 'ស្រោមដៃ - Gloves',
                'កន្សែង - Scarf', 'អាវធំ - Jacket', 'អាវយឺតដៃវែង - Sweater', 'ខោជើងវែង - Jeans', 'ខោខ្លី - Shorts',
                'ស្រោមជើង - Socks', 'ស្បែកជើងម៉ូកាស៊ីន - Boots', 'ស្បែកជើងផ្ទាត់ - Sandals', 'ខ្សែក្រវាត់ - Belt',
                'កាបូបលុយ - Wallet', 'វ៉ែនតា - Sunglasses', 'ក្រវិល - Earrings', 'ខ្សែក - Necklace',
                'ខ្សែដៃ - Bracelet', 'ចិញ្ចៀន - Ring', 'ជើងកាមេរ៉ា - Tripod', 'ម៉ាស៊ីនបោះពុម្ព - Printer',
                'ម៉ាស៊ីនស្កេន - Scanner', 'ម៉ាស៊ីនបញ្ចាំង - Projector', 'ប៊ិច - Pen', 'សៀវភៅកត់ត្រា - Notebook',
                'គណនេយ្យករ - Calculator', 'បន្ទះគូសបន្ទាត់ - Ruler', 'ជ័រលុប - Eraser', 'ម៉ាស៊ីនកាត់ក្រដាស - Sharpener',
                'ម៉ាស៊ីនចាក់ក្រដាស - Stapler', 'កាវ - Glue', 'ថ្នាំលាប - Paint', 'ដុំដាក់ផ្កា - Vase',
                'ដើមឈើ - Plant', 'ផ្កា - Flower Pot', 'អាវទ្រនាប់ - Curtains', 'កម្រាលព្រំ - Rug',
                'កញ្ចក់ - Mirror', 'នាឡិកាខ្យល់ - Clock', 'សាប៊ូ - Soap', 'សាប៊ូកក់សក់ - Shampoo',
                'ថ្នាំដុសធ្មេញ - Toothpaste', 'ច្រាសដុសធ្មេញ - Toothbrush', 'កន្ត្រៃ - Scissors', 'ក្រដាស - Paper',
                'សំបុត្រ - Envelope', 'ស្រោមដៃ - Gloves', 'កន្សែងជូត - Towel', 'កន្ត្រៃកាត់សក់ - Hair Dryer',
                'កុំព្យូទ័រ - Laptop', 'ទូរស័ព្ទដៃ - Smartphone', 'ថេប្លេត - Tablet', 'កាស - Headphones',
                'នាឡិកាឆ្លាតវៃ - Smartwatch', 'កាមេរ៉ា - Camera', 'ម៉ាស៊ីនព្រីន - Printer', 'ម៉ូនីទ័រ - Monitor',
                'ក្តារចុច - Keyboard', 'កណ្តុរ - Mouse', 'តុ - Desk', 'ចង្កៀង - Lamp', 'សាឡុង - Sofa',
                'គ្រែ - Bed', 'ភួយ - Blanket', 'ខ្នើយ - Pillow', 'កែវ - Cup', 'ចាន - Plate',
                'សម - Fork', 'កាំបិត - Knife', 'ស្លាបព្រា - Spoon', 'ដប - Bottle', 'កាបូប - Bag',
                'មួក - Hat', 'ស្រោមដៃ - Gloves', 'កន្សែង - Scarf', 'អាវធំ - Jacket', 'អាវយឺតដៃវែង - Sweater',
                'ខោជើងវែង - Jeans', 'ខោខ្លី - Shorts', 'ស្រោមជើង - Socks', 'ស្បែកជើងម៉ូកាស៊ីន - Boots',
                'ស្បែកជើងផ្ទាត់ - Sandals', 'ខ្សែក្រវាត់ - Belt', 'កាបូបលុយ - Wallet', 'វ៉ែនតា - Sunglasses',
                'ក្រវិល - Earrings', 'ខ្សែក - Necklace', 'ខ្សែដៃ - Bracelet', 'ចិញ្ចៀន - Ring',
                'ជើងកាមេរ៉ា - Tripod', 'Drone - Drone', 'Speaker - Speaker', 'Microphone - Microphone',
                'Headset - Headset', 'Charger - Charger', 'Power Bank - Power Bank', 'Flash Drive - Flash Drive',
                'Hard Drive - Hard Drive', 'Memory Card - Memory Card', 'Printer - Printer', 'Scanner - Scanner',
                'Projector - Projector', 'Pen - Pen', 'Notebook - Notebook', 'Backpack - Backpack', 'Calculator - Calculator',
                'Ruler - Ruler', 'Eraser - Eraser', 'Sharpener - Sharpener', 'Stapler - Stapler', 'Tape - Tape',
                'Glue - Glue', 'Paint - Paint', 'Brush - Brush', 'Canvas - Canvas', 'Easel - Easel',
                'Sketchbook - Sketchbook', 'Crayons - Crayons', 'Markers - Markers', 'Scissors - Scissors', 'Paper - Paper',
                'Envelope - Envelope', 'Clock - Clock', 'Mirror - Mirror', 'Curtains - Curtains', 'Rug - Rug',
                'Vase - Vase', 'Plant - Plant', 'Flower Pot - Flower Pot', 'Broom - Broom', 'Mop - Mop',
                'Bucket - Bucket', 'Detergent - Detergent', 'Soap - Soap', 'Shampoo - Shampoo', 'Conditioner - Conditioner',
                'Toothpaste - Toothpaste', 'Toothbrush - Toothbrush', 'Razor - Razor', 'Towel - Towel', 'Comb - Comb',
                'Hair Dryer - Hair Dryer'
            ]),
            'description' => $this->faker->sentence(10), // Simulates a real product description
            'price' => (string) $this->faker->randomFloat(2, 1, 1000),
            'stock' => $this->faker->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
