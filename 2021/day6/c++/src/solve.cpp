#include <iostream>
#include <fstream>
#include <string>
#include <vector>
using namespace std;

typedef signed char Fish;
typedef unsigned long long int FishCount;
typedef vector<Fish> Aquarium;

void output(string message, int newlines) {
    cout << message;
    while (newlines > 0) {
        cout << "\r\n";
        newlines--;
    }
}

Fish toFish(char c) {
    return (Fish)(c - '0');
}

Aquarium loadAquarium() {
    // Read in the input data
    string line;
    string data;
    ifstream inputFile("../input.txt");
    if (inputFile.is_open()) {
        while (getline(inputFile, line)) {
            data = line;
        }
    }
    inputFile.close();
    data.erase(std::remove(data.begin(), data.end(), ','), data.end()); // Remove the comma's (,)

    // Load the fish into the aquarium
    Aquarium aquarium;
    for (int i = 0; i < data.length(); i++) {
        Fish f = toFish(data[i]);
        aquarium.push_back(f);
    }

    return aquarium;
}

void saveAquarium(Aquarium aquarium, int day) {
    ofstream outputFile("output-" + std::to_string(day) + ".txt");
    if (outputFile.is_open()) {
        // Save the aquarium to file
        FishCount s = aquarium.size();
        for (FishCount i = 0; i < s; i++) {
            outputFile << aquarium[i];
            if ((i + 1) != s) {
                outputFile << ",";
            }
        }
    }
    outputFile.close();
}

Aquarium simulate(Aquarium aquarium, int days) {
    output("Simulating " + std::to_string(days) + "days...", 1);

    for (int day = 1; day <= days; day++) {
        FishCount currentAquariumSize = aquarium.size();
        for (FishCount f = 0; f < currentAquariumSize; f++) {
            Fish fish = aquarium[f];
            fish -= 1;
            if (fish < 0) {
                fish = 6;
                aquarium.push_back(8);
            }
            aquarium[f] = fish;
        }
        FishCount count = aquarium.size();
        output("Day " + std::to_string(day) + " => Started at " + std::to_string(currentAquariumSize) + ", ended at " + std::to_string(count), 1);
    }

    return aquarium;
}

int main() {
    output("Advent of Code 2021 - Day 6", 1);
    output("Puzzle: C++ Lanternfish (Part 2)", 1);
    output("Let's go!", 2);

    // Load the data
    Aquarium aquarium = loadAquarium();

    // Simulate 256 days
    aquarium = simulate(aquarium, 256);

    output("Solution: " + std::to_string(aquarium.size()) + " lanterfish after 256 days", 2);

    return 0;
}