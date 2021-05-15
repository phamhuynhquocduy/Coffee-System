package com.example.coffeesystem

import android.content.ContentValues
import android.content.Context
import android.database.Cursor
import android.database.sqlite.SQLiteDatabase
import android.database.sqlite.SQLiteOpenHelper
import android.provider.ContactsContract.CommonDataKinds.Phone
import android.util.Log
import com.example.coffeesystem.model.Cart
import com.example.coffeesystem.network.url





class DatabaseHandler(context: Context): SQLiteOpenHelper(
        context,
        DATABASE_NAME,
        null,
        DATABASE_VERSION
)  {
    companion object {
        private val DATABASE_VERSION = 1
        private val DATABASE_NAME = "cart"
        private val TABLE_CONTACTS = "cart"
        private val ID_USER = "iduser"
        private val ID_PRODUCT = "idproduct"
        private val NAME = "name"
        private val IMAGE = "image"
        private val DESCRIPTION= "description"
        private val PRICE = "price"
        private val IDCATEGORY = "idcategory"
        private val COUNT = "count"
    }

    override fun onCreate(db: SQLiteDatabase?) {
        val CREATE_CONTACTS_TABLE = ("CREATE TABLE " + TABLE_CONTACTS + "("
                + ID_USER + " INTEGER," + ID_PRODUCT + " INTEGER,"
                + NAME + " TEXT,"+ IMAGE+" TEXT,"+ DESCRIPTION + " TEXT,"+ PRICE + " REAL,"+ IDCATEGORY + " INTEGER,"+ COUNT + " INTEGER"+ ")")
        db?.execSQL(CREATE_CONTACTS_TABLE)      }

    override fun onUpgrade(db: SQLiteDatabase?, oldVersion: Int, newVersion: Int) {
        db!!.execSQL("DROP TABLE IF EXISTS " + TABLE_CONTACTS)
        onCreate(db)
    }
    fun viewCart():ArrayList<Cart>{
        val cart:ArrayList<Cart> = ArrayList<Cart>()
        val selectQuery = "SELECT  * FROM $TABLE_CONTACTS"
        val db = this.readableDatabase
        var cursor: Cursor? = null
        try{
            cursor = db.rawQuery(selectQuery, null)
        }catch (e: Exception) {
            db.execSQL(selectQuery)
            return ArrayList()
        }
        var userId: Int
        var userProdcut: Int
        var name: String
        var image : String
        var description : String
        var price : Double
        var idCategory : Int
        var count : Int
        if (cursor.moveToFirst()) {
            do {
                userId = cursor.getInt(cursor.getColumnIndex("iduser"))
                userProdcut = cursor.getInt(cursor.getColumnIndex("idproduct"))
                name = cursor.getString(cursor.getColumnIndex("name"))
                image = cursor.getString(cursor.getColumnIndex("image"))
                description = cursor.getString(cursor.getColumnIndex("description"))
                price =  cursor.getDouble(cursor.getColumnIndex("price"))
                idCategory = cursor.getInt(cursor.getColumnIndex("idcategory"))
                count = cursor.getInt(cursor.getColumnIndex("count"))


                val itemCart= Cart(
                        userId,
                        userProdcut,
                        name, image,
                        description,
                        price,
                        idCategory,
                        count
                )
                cart.add(itemCart)
            } while (cursor.moveToNext())
        }
        return cart
    }

    fun getCartCount(): Int {
        val countQuery = "SELECT  * FROM $TABLE_CONTACTS"
        val db = this.readableDatabase
        val cursor = db.rawQuery(countQuery, null)
        val count = cursor.count
        cursor.close()

        // return count
        return count
    }
    fun addCart(cart: Cart):Long{
        val db = this.writableDatabase
        val contentValues = ContentValues()
        contentValues.put(ID_USER, cart.idUser)
        contentValues.put(ID_PRODUCT, cart.idProduct)
        contentValues.put(NAME, cart.name)
        contentValues.put(PRICE, cart.price)
        contentValues.put(IMAGE, cart.image)
        contentValues.put(DESCRIPTION, cart.description)
        contentValues.put(IDCATEGORY, cart.idcategory)
        contentValues.put(COUNT, cart.count)
        // Inserting Row
        val success = db.insert(TABLE_CONTACTS, null, contentValues)
        //2nd argument is String containing nullColumnHack
        db.close() // Closing database connection
        return success
    }
    fun deleteCart(cart: Cart) {
        val db = this.writableDatabase
        db.delete(TABLE_CONTACTS, ID_PRODUCT+ " = ?", arrayOf(cart.idProduct.toString()))
        db.close()
    }
    fun updateCart(cart: Cart, count : Int):Int{
        val db = this.writableDatabase
        val contentValues = ContentValues()
        contentValues.put(COUNT, count)
        // Updating Row
        val success = db.update(TABLE_CONTACTS, contentValues,"idproduct="+cart.idProduct,null)
        db.close() // Closing database connection
        return success
    }
}