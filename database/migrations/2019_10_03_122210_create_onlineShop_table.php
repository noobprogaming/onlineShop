<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);

        Schema::create('item', function (Blueprint $table) {
            $table->bigIncrements('item_id');
            $table->string('name', 255); 
            $table->string('description', 255);
            $table->integer('stock');
            $table->bigInteger('purchasing_price');
            $table->bigInteger('selling_price');
            $table->integer('weight');
            $table->integer('category_id')->unsigned(); //foreignKey
            $table->bigInteger('id')->unsigned(); //foreignKey
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->engine = 'InnoDB';
        });

        Schema::create('category', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('explanation', 255);
            $table->engine = 'InnoDB';
        });

        Schema::create('purchase_item', function (Blueprint $table) {
            $table->integer('amount');
            $table->bigInteger('purchasing_price');
            $table->bigInteger('selling_price');
            $table->bigInteger('purchase_id')->unsigned(); //foreignKey
            $table->bigInteger('item_id')->unsigned(); //foreignKey
            $table->bigInteger('seller_id')->unsigned(); //foreignKey
            $table->bigInteger('buyer_id')->unsigned(); //foreignKey
            $table->engine = 'InnoDB';
        });

        Schema::create('purchase', function (Blueprint $table) {
            $table->bigIncrements('purchase_id');
            $table->string('resi')->unique()->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->bigInteger('shipping_price')->nullable();
            $table->string('note')->nullable();
            $table->bigInteger('seller_id')->unsigned(); //foreignKey
            $table->bigInteger('buyer_id')->unsigned(); //foreignKey
            $table->timestamp('time')->nullable();
            $table->engine = 'InnoDB';
        });

        Schema::create('rating', function (Blueprint $table) {
            $table->integer('rating');
            $table->string('review', 255);
            $table->bigInteger('item_id')->unsigned(); //foreignKey
            $table->bigInteger('id')->unsigned(); //foreignKey
            $table->timestamp('time')->useCurrent();
            $table->engine = 'InnoDB';
        });

        Schema::create('location', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned(); //foreignKey
            $table->string('address', 255);
            $table->string('city_id', 255);
            $table->string('province', 255);
            $table->integer('postal_code');
            $table->engine = 'InnoDB';
        });

        Schema::create('provinceloc', function (Blueprint $table) {
            $table->integer('province_id');
            $table->string('province_name', 255);
            $table->primary('province_id');
            $table->engine = 'InnoDB';
        });

        Schema::create('cityloc', function (Blueprint $table) {
            $table->integer('city_id');
            $table->integer('province_id')->unsigned(); //foreignKey
            $table->string('type', 255);
            $table->string('city_name', 255);
            $table->primary('city_id');
            $table->engine = 'InnoDB';
        });

        Schema::create('postal', function (Blueprint $table) {
            $table->integer('postal_code', 255);
            $table->string('district', 255);
            $table->string('urban', 255);
            $table->string('city', 255);
            $table->primary('postal_code');
            $table->engine = 'InnoDB';
        });

        DB::statement('ALTER TABLE item ADD CONSTRAINT fk_itemCategory_id FOREIGN KEY (category_id) REFERENCES category(category_id);');
        DB::statement('ALTER TABLE item ADD CONSTRAINT fk_itemUsers_id FOREIGN KEY (id) REFERENCES users(id);');

        DB::statement('ALTER TABLE purchase_item ADD CONSTRAINT fk_piPurchase_id FOREIGN KEY (purchase_id) REFERENCES purchase(purchase_id);');
        DB::statement('ALTER TABLE purchase_item ADD CONSTRAINT fk_piItem_id FOREIGN KEY (item_id) REFERENCES item(item_id);');
        DB::statement('ALTER TABLE purchase_item ADD CONSTRAINT fk_piSeller_id FOREIGN KEY (seller_id) REFERENCES users(id);');
        DB::statement('ALTER TABLE purchase_item ADD CONSTRAINT fk_piBuyer_id FOREIGN KEY (buyer_id) REFERENCES users(id);');

        DB::statement('ALTER TABLE purchase ADD CONSTRAINT fk_purchaseSeller_id FOREIGN KEY (seller_id) REFERENCES users(id);');
        DB::statement('ALTER TABLE purchase ADD CONSTRAINT fk_purchaseBuyer_id FOREIGN KEY (buyer_id) REFERENCES users(id);');
    
        DB::statement('ALTER TABLE rating ADD CONSTRAINT fk_ratingItem_id FOREIGN KEY (item_id) REFERENCES item(item_id);');
        DB::statement('ALTER TABLE rating ADD CONSTRAINT fk_ratingUsers_id FOREIGN KEY (id) REFERENCES users(id);');

        DB::statement('ALTER TABLE location ADD CONSTRAINT fk_locationUsers_id FOREIGN KEY (user_id) REFERENCES users(id);');
        DB::statement('ALTER TABLE location ADD CONSTRAINT fk_locationCity_id FOREIGN KEY (city_id) REFERENCES cityloc(city_id);');
        DB::statement('ALTER TABLE location ADD CONSTRAINT fk_locationProvince_id FOREIGN KEY (province_id) REFERENCES provinceloc(province_id);');
        DB::statement('ALTER TABLE location ADD CONSTRAINT fk_locationPostal_code FOREIGN KEY (postal_code) REFERENCES postal(postal_code);');

        DB::statement('ALTER TABLE cityloc ADD CONSTRAINT fk_citiLocProvinceId FOREIGN KEY (province_id) REFERENCES provinceLoc(province_id)');


        //SELECT location.address, location.districts, cityLoc.city_name, provinceLoc.province_name FROM location
        // INNER JOIN cityloc ON cityLoc.city_id = location.city_id
        // INNER JOIN provinceLoc ON provinceloc.province_id = location.province_id
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('purchase_item');
        Schema::dropIfExists('purchase');
        Schema::dropIfExists('rating');
    }
}
