#include <iostream>
#include <iomanip>
#include <string>
#include <windows.h>
#include <limits>
#include <conio.h>

using namespace std;

void loading();

int errorInt(int value)
{
    // Loop until a valid integer is obtained
    while (!(cin >> value) || cin.fail())
    {
        // Input is invalid, clear the input buffer and ignore remaining characters
        cin.clear();                                         // Clear the error flag
        cin.ignore(numeric_limits<streamsize>::max(), '\n'); // Discard invalid input

        // Display an error message
        cout << "\t\t\t\t\t Invalid input. Please enter a valid integer.\n\t\t\t\t\t ";
    }

    // Return the valid integer value
    return value;
}

// Define a simple food item structure
struct FoodItem
{
    int id;
    string name;
    float price;
};

// Define a binary tree node
struct TreeNode
{
    FoodItem data;
    TreeNode *left;
    TreeNode *right;
};

// Function to create a new tree node
TreeNode *createNode(const FoodItem &item)
{
    // Allocate memory for a new TreeNode
    TreeNode *newNode = new TreeNode;

    // Assign the provided FoodItem to the data of the new node
    newNode->data = item;

    // Set the left and right pointers of the new node to nullptr
    newNode->left = newNode->right = nullptr;

    // Return the pointer to the newly created node
    return newNode;
}

// Function to search for a food item in a binary search tree
TreeNode *searchFood(TreeNode *root, int foodId)
{
    // Base cases:
    // 1. If the root is nullptr, the item is not found.
    // 2. If the id of the current node is equal to the target foodId, the item is found.
    if (root == nullptr || root->data.id == foodId)
    {
        return root;
    }

    // If the target foodId is less than the id of the current node,
    // recursively search in the left subtree.
    if (foodId < root->data.id)
    {
        return searchFood(root->left, foodId);
    }
    // If the target foodId is greater than the id of the current node,
    // recursively search in the right subtree.
    else
    {
        return searchFood(root->right, foodId);
    }
}

// Function to add a new food item to a binary search tree
TreeNode *addFood(TreeNode *root, const FoodItem &newItem)
{
    // Base case: If the current node is nullptr, create a new node with the new item.
    if (root == nullptr)
    {
        return createNode(newItem);
    }

    // Recursive cases:

    // If the ID of the new item is less than the ID of the current node,
    // recursively add the new item to the left subtree.
    if (newItem.id < root->data.id)
    {
        root->left = addFood(root->left, newItem);
    }
    // If the ID of the new item is greater than the ID of the current node,
    // recursively add the new item to the right subtree.
    else if (newItem.id > root->data.id)
    {
        root->right = addFood(root->right, newItem);
    }

    // Return the current node (with its potential modifications) to maintain the structure of the tree.
    return root;
}

// Function to insert a food item into the BST
TreeNode *insert(TreeNode *root, const FoodItem &item)
{
    // Base case: If the current node is nullptr, create a new node with the new item.
    if (root == nullptr)
    {
        return createNode(item);
    }

    // Recursive cases:

    // If the ID of the new item is less than the ID of the current node,
    // recursively insert the new item into the left subtree.
    if (item.id < root->data.id)
    {
        root->left = insert(root->left, item);
    }
    // If the ID of the new item is greater than the ID of the current node,
    // recursively insert the new item into the right subtree.
    else if (item.id > root->data.id)
    {
        root->right = insert(root->right, item);
    }

    // Return the current node (with its potential modifications) to maintain the structure of the tree.
    return root;
}

// Function to display the food catalog using in-order traversal
void displayCatalog(TreeNode *root)
{
    // Base case: If the current node is nullptr, return.
    if (root != nullptr)
    {
        // Recursive case:

        // Traverse the left subtree
        displayCatalog(root->left);

        // Process the current node (display the food item)
        cout << "\t\t\t\t\t   " << root->data.id << "\t\t" << root->data.name << "\t P" << fixed << setprecision(2) << root->data.price << endl;

        // Traverse the right subtree
        displayCatalog(root->right);
    }
}

class Queue
{
private:
    struct QueueNode
    {
        int orderId;
        string foodName;
        float totalAmount;
    };

    static const int MAX_QUEUE_SIZE = 10; // Adjust the size based on your needs
    QueueNode queueArray[MAX_QUEUE_SIZE];
    int front;
    int rear;

public:
    Queue() : front(-1), rear(-1) {}

    void enqueue(int orderId, const string &foodName, float totalAmount)
    {
        if (rear == MAX_QUEUE_SIZE - 1)
        {
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\tQueue is full. Cannot add more orders." << endl;
            return;
        }

        rear++;
        queueArray[rear].orderId = orderId;
        queueArray[rear].foodName = foodName;
        queueArray[rear].totalAmount = totalAmount;

        if (front == -1)
        {
            front = 0;
        }
    }

    void dequeue()
    {
        if (front == -1)
        {
            cout << "\n\n\n\n\n\n";
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\t   Queue is empty. Cannot dequeue orders." << endl;
            cout << "\t\t\t\t\t============================================" << endl;
            return;
        }

        cout << "\n\n\n\n\n\n";
        cout << "\t\t\t\t\t============================================" << endl;
        cout << "\t\t\t\t\t     P R O C E S S I N G  O R D E R S             " << endl;
        cout << "\t\t\t\t\t============================================" << endl;

        float total = 0;
        int currentOrderId = queueArray[front].orderId;
        cout << "\t\t\t\t\tOrder ID: " << queueArray[front].orderId << endl;
        while (front != -1 && queueArray[front].orderId == currentOrderId)
        {
            cout << "\t\t\t\t\t  Food: " << queueArray[front].foodName
                 << "  Total Amount: P" << fixed << setprecision(2) << queueArray[front].totalAmount << endl;

            total += queueArray[front].totalAmount;

            if (front == rear)
            {
                front = rear = -1;
            }
            else
            {
                front++;
            }
        }
        cout << "\t\t\t\t\t============================================" << endl;
        cout << "\t\t\t\t\t   TOTAL: P" << fixed << setprecision(2) << total << endl;
    }

    void peek()
    {
        if (front == -1)
        {
            cout << "\n\n\n\n\n\n";
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\t    Queue is empty. No orders to peek." << endl;
            cout << "\t\t\t\t\t============================================" << endl;
            return;
        }

        cout << "\n\n\n\n\n\n";
        cout << "\t\t\t\t\t============================================" << endl;
        cout << "\t\t\t\t\t            F R O N T  O R D E R" << endl;
        cout << "\t\t\t\t\t============================================" << endl;
        cout << "\t\t\t\t\t Order ID: " << queueArray[front].orderId << endl;
        cout << "\t\t\t\t\t  Food: " << queueArray[front].foodName
             << "Total Amount: P" << fixed << setprecision(2) << queueArray[front].totalAmount << endl;
        cout << "\t\t\t\t\t============================================" << endl;
    }

    void display()
    {
        if (front == -1)
        {
            cout << "\n\n\n\n\n\n";
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\t   Queue is empty. No orders to display." << endl;
            cout << "\t\t\t\t\t============================================" << endl;
            return;
        }

        cout << "\n\n\n\n\n\n";
        cout << "\t\t\t\t\t============================================" << endl;
        cout << "\t\t\t\t\t     O R D E R S  I N  T H E  Q U E U E " << endl;
        cout << "\t\t\t\t\t============================================" << endl;
        for (int i = front; i <= rear; ++i)
        {
            cout << "\t\t\t\t\t Order ID: " << queueArray[i].orderId << endl;
            cout << "\t\t\t\t\t  Food: " << queueArray[i].foodName
                 << "  Total Amount: P" << fixed << setprecision(2) << queueArray[i].totalAmount << endl;
            cout << "\t\t\t\t\t============================================" << endl;
        }
    }
};

int main()
{
    TreeNode *foodCatalogTree = nullptr;
    Queue orderQueue;

    loading();

    FoodItem foodCatalog[] = {
        {101, "Chicken Joy", 49.99},
        {102, "Jolly Spaghetti", 99.99},
        {103, "Burger Steak", 69.99},
        {104, "Yumburger", 49.99},
        {105, "Palabok Fiesta", 45.99}
        // Add more food items as needed
    };

    for (const auto &item : foodCatalog)
    {
        foodCatalogTree = insert(foodCatalogTree, item);
    }

    int choice;
    do
    {
        cout << "\n\n\n\n\n\n";
        cout << "\t\t\t\t\t============================================" << endl;
        cout << "\t\t\t\t\t     J O L I K O D   R E S T O  I N N.      " << endl;
        cout << "\t\t\t\t\t============================================" << endl;
        cout << "\t\t\t\t\t\t1. Display Food Catalog" << endl;
        cout << "\t\t\t\t\t\t2. Place an Order" << endl;
        cout << "\t\t\t\t\t\t3. Process Orders" << endl;
        cout << "\t\t\t\t\t\t4. Peek at the Front Order" << endl;
        cout << "\t\t\t\t\t\t5. Display Orders" << endl;
        cout << "\t\t\t\t\t\t6. Add Food" << endl;
        cout << "\t\t\t\t\t\t7. Exit" << endl;
        cout << "\t\t\t\t\t============================================" << endl;
        cout << "\t\t\t\t\t\tEnter your choice: ";
        choice = errorInt(choice);
        system("cls");

        switch (choice)
        {
        case 1:
            cout << "\n\n\n\n\n\n";
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\t              F O O D   M E N U             " << endl;
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\t=  ID\t\tName\t         Price     =" << endl;
            cout << "\t\t\t\t\t============================================" << endl;
            displayCatalog(foodCatalogTree);
            cout << "\t\t\t\t\t============================================" << endl;

            cout << "\n\t\t\t\t\t";
            system("pause");
            system("cls");
            break;

        case 2:
        {
            int orderId, foodId, quantity;

            cout << "\n\n\n\n\n\n";
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\t              F O O D   M E N U             " << endl;
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\t=  ID\t\tName\t         Price     =" << endl;
            cout << "\t\t\t\t\t============================================" << endl;
            displayCatalog(foodCatalogTree);
            cout << "\t\t\t\t\t============================================" << endl;

            cout << "\t\t\t\t\tEnter Order ID: ";
            orderId = errorInt(choice);

            // Allow the user to add multiple food items to the order
            char orderAgain;
            do
            {
                int foodId;
                cout << "\t\t\t\t\tEnter Food ID: ";
                foodId = errorInt(choice);

                // Search for the food item in the catalog
                TreeNode *foundNode = searchFood(foodCatalogTree, foodId);

                if (foundNode != nullptr)
                {
                    cout << "\t\t\t\t\tEnter Quantity: ";
                    quantity = errorInt(choice);
                    float totalAmount = quantity * foundNode->data.price;

                    orderQueue.enqueue(orderId, foundNode->data.name, totalAmount);
                }
                else
                {
                    cout << "\t\t\t\t\tInvalid Food ID. Please try again." << endl;
                }

                cout << "\t\t\t\t\tDo you want to order again? (y/n): ";
                cin >> orderAgain;
                cout << "\t\t\t\t\t============================================" << endl;

            } while (orderAgain == 'y' || orderAgain == 'Y');

            cout << "\t\t\t\t\tOrder placed successfully." << endl;

            cout << "\n\t\t\t\t\t";
            system("pause");
            system("cls");
            break;
        }

        case 3:
            orderQueue.dequeue();
            cout << "\n\t\t\t\t\t";
            system("pause");
            system("cls");
            break;

        case 4:
            orderQueue.peek();
            cout << "\n\t\t\t\t\t";
            system("pause");
            system("cls");
            break;

        case 5:
            orderQueue.display();
            cout << "\n\t\t\t\t\t";
            system("pause");
            system("cls");
            break;

        case 6:
        {
            FoodItem newItem;
            cout << "\n\n\n\n\n\n";
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\t            A D D  N E W  F O O D           " << endl;
            cout << "\t\t\t\t\t============================================" << endl;
            cout << "\t\t\t\t\tEnter new food details:" << endl;
            cout << "\t\t\t\t\tEnter ID: ";
            while (!(cin >> newItem.id) || cin.fail())
            {
                cout << "\t\t\t\t\tInvalid input. Please enter a valid integer for ID.\n";
                cin.clear();
                cin.ignore(numeric_limits<streamsize>::max(), '\n');
            }

            TreeNode *foundNode = searchFood(foodCatalogTree, newItem.id);
            if (foundNode != nullptr)
            {
                cout << "\t\t\t\t\tFood ID already exists. Please choose a different ID.\n";
                cout << "\t\t\t\t\t";
                system("pause");
                system("cls");
                break;
            }

            cout << "\t\t\t\t\tEnter Name: ";
            cin.ignore(); // Ignore newline character left in the buffer
            getline(cin, newItem.name);

            cout << "\t\t\t\t\tEnter Price: P";
            while (!(cin >> newItem.price) || cin.fail() || newItem.price <= 0)
            {
                cout << "\t\t\t\t\tInvalid input. Please enter a valid numeric value for Price.\n";
                cin.clear();
                cin.ignore(numeric_limits<streamsize>::max(), '\n');
            }

            foodCatalogTree = addFood(foodCatalogTree, newItem);

            cout << "\t\t\t\t\tFood added successfully." << endl;
            cout << "\n\t\t\t\t\t";
            system("pause");
            system("cls");
            break;
        }

        case 7:
            cout << "\t\t\t\t\tExiting program. Thank you!" << endl;
            break;

        default:
            cout << "\t\t\t\t\tInvalid choice. Please try again." << endl;
        }
    } while (choice != 7);

    return 0;
}

void loading()
{
    cout << "\n\n\n\t\t\t=================================================================================" << endl;
    cout << "\t\t\t|        ===     ======     ===      ===   ===  ===     ======     ========     |" << endl;
    cout << "\t\t\t|        ===   ====  ====   ===      ===   === ==     ====  ====   ===   ====   |" << endl;
    cout << "\t\t\t|        ===   ===    ===   ===      ===   =====      ===    ===   ===     ===  |" << endl;
    cout << "\t\t\t| ===    ===   ===    ===   ===      ===   === ==     ===    ===   ===     ===  |" << endl;
    cout << "\t\t\t| ===    ===   ====  ====   ======   ===   ===  ==    ====  ====   ===   ====   |" << endl;
    cout << "\t\t\t|  ========      ======     ======   ===   ===   ===    ======     ========     |" << endl;
    cout << "\t\t\t=================================================================================" << endl;

    cout << "\t\t\t";
    for (int i = 0; i < 80; i++)
    {
        cout << ".";
        Sleep(40);
    }

    system("cls");
}
